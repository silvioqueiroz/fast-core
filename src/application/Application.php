<?php
namespace fastblocks\core\application;

use fastblocks\core\application\Configuration;
use fastblocks\core\exception\PageNotFoundException;
use fastblocks\logger\LoggerFactory as Logger;
use fastblocks\core\context\Request;

class Application
{

    protected $log;
    protected $template;

    function __construct()
    {
        $this->log = Logger::getLogger(Application);
    }

    function run($module = null, $function_name = "execute")
    {
        $this->log->logDebug("Start intercept request.");
        try {
            $request = new Request();
            $this->preFiltering($request);
            // quebra a url
            // TODO: construir block para quebra da url
            // identifica a action e a inneraction
            $function_name = $_REQUEST[''];
            // solicita a criação da action à factory
            $strategy = Configuration::STRATEGY_PROPERTIES();
            $action = $strategy::createAction($module);
            // action retorna o resultado do processamento
            $response = $action->execute($request);
            // repassa o retono para a Engine template
            $clazz = Configuration::TEMPLATE_CLASS;
            $template = new $clazz($this->defaultBase);
            $emplate->show();
            // template->show($result);
        } catch (PageNotFoundException $e) {
            echo "Sorry, the page you were looking for in this blog does not exist.";
        } catch (Exception $e) {
            // FIXME: adicionar pagina de tratamento de erro a partir de um filtro
            echo "Erro interno: " . $e->getCode() . " - " . $e->getTrace();
            echo "<br/><pre>$e</pre><br/>";
            throw $e;
        } finally {
            // encerra o tratamento da requisição
            $this->posFiltering($response);
            $this->log->logDebug("End request. ");
        }
    }

    function exception_handler($exception)
    {
        echo "Uncaught exception: ", $exception->getMessage(), "\n";
    }

    function error_handler($errno, $errstr)
    {
        echo "<b>Error:</b> [$errno] $errstr<br />";
        echo "Ending Script";
        die();
    }

    function error_reporting()
    { // ($level = E_PARSE) {
        error_reporting(Configuration::ERROR_REPORTING());
    }

    function preFiltering(Request $request)
    {
        // valida a requisição
        $this->validateData();
        // efetua as conversões de dados
        $this->converterData();
    }

    function posFiltering($response)
    {}
}

?>
