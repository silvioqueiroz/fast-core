<?php
namespace fastblocks\core\roter;

use fastblocks\core\util\FastUtil;
use fastblocks\logger\TLoggerFactory;

class SampleStrategy
{

    function isNull($valor)
    {
        return (/*$valor == ""); ||*/ $valor == null);
    }

    public static function createAction($module = 'index')
    {
        $logger = TLoggerFactory::getLogger();
        // Se o module não for informado, ele passa a ser considerado o index;
        if (! FastUtil::isEmptyOrNull($_REQUEST, 'module')) {
            $module = $_REQUEST['module'];
        }
        
        // A mesma coisa para a action
        $action = 'index';
        if (! FastUtil::isEmptyOrNull($_REQUEST, 'action')) {
            $action = $_REQUEST['action'];
        }
        
        $logger->logInfo("Create command module = $module and action = $action ");
        
        // Deixa a primeira letra em Maiusculo e o resto da string em minusculo
        $module = ucfirst(strtolower($module));
        $action = ucfirst(strtolower($action));
        
        // Cria o nome do arquivo da Action
        $fileName = 'app.action/' . $module . '/' . $action . '.php';
        
        $logger->logInfo("require_once '$fileName'");
        
        // Cria o nome do arquivo da Action
        if (file_exists($fileName)) {
            // Carrega o arquivo que contem a classe do Command
            require_once $fileName;
            
            // O nome da classe é a Action seguida da String Command
            $className = $action;
            $logger->logInfo("className '$className'");
            // Carrega a classe e retorna
            return new $className();
        } else {
            throw new PageNotFoundException("Erro 404 - Página $className não encontrada");
        }
    }
}

?>