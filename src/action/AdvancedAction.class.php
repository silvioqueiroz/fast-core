<?php

/*
 * require_once FAST_PATH.'/template/AdvancedTemplate.class.php';
 * require_once FAST_PATH.'/template/SmartTemplate.class.php';
 * require_once FAST_PATH.'/template/SmartyTemplate.class.php';
 */
require_once FAST_PATH . '/i18n/ResourceBundleFactory.class.php';
require_once FAST_PATH . '/i18n/ResourceBundle.class.php';
require_once FAST_PATH . "/logger/TLoggerFactory.php";
require_once FAST_PATH . "/util/UserUtil.class.php";
require_once (FAST_PATH . '/TitanConstants.class.php');
require_once (FAST_PATH . '/constants/Constants.class.php');
require_once (FAST_PATH . '/TemplateConstants.class.php');
require_once FAST_PATH . "/util/DateTimeCompatibility.class.php";
require_once FAST_PATH . "/core/context/Context.class.php";

require_once (FAST_PATH . '/orm/TTransaction.class.php');
require_once (FAST_PATH . '/orm/TRepository.class.php');

/**
 *
 * Enter description here ...
 *
 * @author Silvio Pereira
 *        
 */
abstract class AdvancedAction
{

    private $autoload;

    protected $template;

    private $requiredLogged = TRUE;

    private $login_template = "login";

    /**
     *
     * Define the key of the session user/client of the system.
     *
     * @var String
     */
    protected $session_key = null;

    protected $get_context = null;

    protected $post_context = null;

    protected $session_context = null;

    protected $input = null;

    protected $call_function = "process";

    /**
     *
     * Define the loger instance of the action
     *
     * @var TLogger
     */
    protected $logger = null;

    public function set_call_function($value)
    {
        $this->call_function = $value;
    }

    /**
     *
     * Enter description here ...
     *
     * @param unknown_type $flag            
     */
    function requiredLogger($flag)
    {
        $this->logger->logInfo("AdvancedAction.requiredLogger($flag)");
        $this->requiredLogged = $flag;
    }

    /**
     * Enter description here .
     * ..
     */
    public function __construct()
    {
        $clazz = ApplicationContext::TEMPLATE_CLASS;
        $this->template = new $clazz($this->defaultBase);
        session_start();
        $this->session_key = TitanConstants::LOGIN_CLIENT;
        $this->logger = TLoggerFactory::getLogger();
        $this->get_context = new Context($_GET);
        $this->post_context = new Context($_POST);
        $this->session_context = new Context($_SESSION);
        $this->input = new Context($_REQUEST);
        // open conection
        // FIXME: criar classe de constantes para guardar constantes
        TTransaction::open('connection');
        
        $filter_list = ApplicationContext::FILTER_LIST();
        $filter = null;
        for ($i = 0; $i < count($filter_list); $i ++) {
            $filter = new $filter_list[$i]();
            $filter->execute();
        }
        
        // LOG
        // XXX: colocar em classe utilitaria do logs
        /*
         * if ($_POST){
         * foreach ($_POST as $key=>$value){
         * if('string'!==gettype($value)) $_POST[$key]='';
         *
         * $retorno[]="{$key}:{$value}";
         * }
         * $this->logger->logInfo("POST [".implode(' ; ', $retorno)."]");
         * }
         * if ($_GET){
         * foreach ($_GET as $key=>$value){
         * if('string'!==gettype($value)) $_GET[$key]='';
         *
         * $retorno[]="{$key}={$value}";
         * }
         * $this->logger->logInfo("GET [".implode(' ; ', $retorno)."]");
         * }
         */
    }

    function __destruct()
    {
        // FIXME: melhorar tratamento de conexão
        TTransaction::close();
    }

    /**
     *
     * Enter description here ...
     *
     * @param unknown_type $page            
     */
    final function page($page)
    {
        $this->logger->logInfo("AdvancedAction.page($page)");
        $this->template->setPage($page);
    }

    final function setPage($page)
    {
        $this->page($page);
    }

    /**
     * (non-PHPdoc)
     *
     * @see ActionInterface::flush()
     */
    final function flush()
    {
        $this->logger->logInfo("AdvancedAction.flush()");
        $this->template->show();
    }

    /**
     * (non-PHPdoc)
     *
     * @see ActionInterface::execute()
     */
    final function execute()
    {
        // FIXME: usar utilitario de abstracao de header
        // FIXME: pegar tipo do charset a partir de configuração
        header('Content-Type: text/html; charset=' . ApplicationContext::CHARSET_PROPERTIES());
        $this->logger->logInfo("AdvancedAction.execute()");
        if ($this->pre_validate()) {
            $this->logger->logInfo("Valid condition");
            $this->loadLocale();
            if ($this->validate()) {
                $this->logger->logInfo("Valido");
                // multi metodo
                if (! FastUtil::isEmptyOrNull($_REQUEST, 'f')) {
                    $this->call_function = $_REQUEST['f'];
                }
                // echo "class " . $this->call_function . "<br/>";
                if (method_exists($this, $this->call_function)) {
                    $returnPage = call_user_func(array(
                        $this,
                        $this->call_function
                    ));
                    // echo "PageReturn $returnPage<br/>";
                    $this->setPage($returnPage);
                } else {
                    echo "Sorry, the page you were looking for in this blog does not exist. " . $this->call_function;
                }
                // $this->process();
                $this->pos_validate();
            }
        } else {
            $this->logger->logInfo("Not valid condition");
            $this->redirectOnLogin();
        }
        $this->flush();
    }

    /**
     * Validações anteriores ao processamento da chamada.
     */
    function pre_validate()
    {
        /*
         * $this->logger->logInfo("AdvancedAction.pre_validate()");
         * //echo $this->requiredLogged;
         * if ($this->requiredLogged){
         * $this->logger->logInfo("isUserLogged = ".UserUtil::isUserLogged(TitanConstants::LOGIN_USER));
         * return UserUtil::isUserLogged(TitanConstants::LOGIN_USER);
         * }else{
         * return TRUE;
         * }
         */
        return true;
    }

    /**
     * Validações anteriores ao processamento da chamada.
     */
    function pos_validate()
    {}

    /**
     * Enter description here .
     * ..
     */
    protected function validate()
    {
        // XSS
        return true;
    }

    /**
     * (non-PHPdoc)
     *
     * @see ActionInterface::redirectOnLogin()
     */
    function redirectOnLogin()
    {
        $this->logger->logInfo("AdvancedAction.redirectOnLogin()");
        $this->setPage($this->login_template);
    }

    function setLogin_template($login_template)
    {
        $this->login_template = $login_template;
    }

    /**
     * Enter description here .
     * ..
     */
    private function loadLocale()
    {
        $this->logger->logInfo("AdvancedAction.loadLocale()");
        $locale = $this->get_context->lcl;
        if ($locale != null)
            $this->session_context->Locale = $locale;
    }

    /**
     * (non-PHPdoc)
     *
     * @see AdvancedTemplate::getMessage() function getMessage($key, $locale = null){
     *      $this->logger->logInfo("AdvancedAction.getMessage($key)");
     *      if ($locale == null && $_SESSION["Locale"] == null){
     *      $resourceBundle = ResourceBundleFactory::getResourceBundle();
     *      }else if ($locale == null){
     *      $resourceBundle = ResourceBundleFactory::getResourceBundle($this->session_context->Locale);
     *      }else{
     *      $resourceBundle = ResourceBundleFactory::getResourceBundle($locale);
     *      }
     *      return $resourceBundle->getMessage($key);
     *      }
     */
    public function addFile($varname, $filename)
    {
        $this->template->addFile($varname, $filename);
    }

    public function __set($varname, $value)
    {
        return $this->template->$varname = $value;
    }

    public function loadfile($varname, $filename)
    {
        $this->template->loadfile($varname, $filename);
    }
}

?>
