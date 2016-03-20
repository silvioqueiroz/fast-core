<?php
namespace fastblocks\core\router;

use fastblocks\core\util\FastUtil;
use fastblocks\logger\TLoggerFactory;

/**
 * Estrategia que pega o modulo e a action em apenas um parametro.
 *
 *
 * Exemplo: usuario.add
 *
 * @author Silvio Queiroz
 *        
 */
class WildCardStrategy
{

    public static function createAction($module = 'index')
    {
        $logger = TLoggerFactory::getLogger();
        
        // if (true && !FastUtil::isEmptyOrNull($_REQUEST, 'do')){
        $param = $_SERVER['REQUEST_URI'];
        $count = count(explode("/", $param));
        // echo "size $count<br/>";
        if (strpos($param, '/') !== FALSE && $count > 2) {
            $array = explode("/", $param);
            $module = $array[2] != '' ? $array[2] : 'index';
            $action = $array[3] != '' ? $array[3] : 'index';
            $id = $array[4];
        } else {
            // echo "nope!<br/>";
            $module = 'Index';
            $action = "index";
        }
        // echo "action $action<br/>";
        // echo "module $module<br/>";
        // echo "id $id<br/>";
        
        $logger->logInfo("Create command module = $module and action = $action ");
        
        // Deixa a primeira letra em Maiusculo e o resto da string em minusculo
        $module = ucfirst(strtolower($module));
        
        // Cria o nome do arquivo da Action
        $fileName = 'app.action/' . $module . '.php';
        // kzecho "fileNmae = $fileName <br/>";
        
        $logger->logInfo("require_once '$fileName'");
        
        // /}else{
        // return SampleStrategy::createAction($module);
        // }
        // echo $fileName;
        // Cria o nome do arquivo da Action
        if (file_exists($fileName)) {
            // Carrega o arquivo que contem a classe do Command
            require_once $fileName;
            
            // O nome da classe é a Action seguida da String Command
            $className = $module;
            $logger->logInfo("className '$className'");
            // Carrega a classe e retorna
            // echo "clasName = ".$className."<br/>";
            $actionInstance = new $className();
            $actionInstance->set_call_function($action);
            // echo "action = ".$action."<br/>";
            return $actionInstance;
        } else {
            throw new PageNotFoundException("Erro 404 - Página $className não encontrada");
        }
    }
}

?>