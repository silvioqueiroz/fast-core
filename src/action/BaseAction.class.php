<?php
require_once FAST_PATH . '/i18n/ResourceBundleFactory.class.php';
require_once FAST_PATH . '/i18n/ResourceBundle.class.php';
require_once FAST_PATH . "/logger/TLoggerFactory.php";
require_once FAST_PATH . "/util/UserUtil.class.php";
require_once (FAST_PATH . '/TitanConstants.class.php');
require_once FAST_PATH . "/util/DateTimeCompatibility.class.php";

require_once (FAST_PATH . '/orm/TTransaction.class.php');
require_once (FAST_PATH . '/orm/TRepository.class.php');

abstract class BaseAction
{

    private $logger;

    final function flush()
    {}

    function __autoload($class)
    {
        Application::autoLoad($class);
    }

    final function execute()
    {
        $this->process();
    }

    public function __construct()
    {
        $this->logger = TLoggerFactory::getLogger();
    }

    /**
     * (non-PHPdoc)
     *
     * @see ActionInterface::redirectOnLogin()
     */
    function redirectOnLogin()
    {
        $this->logger->logInfo("AdvancedAction.redirectOnLogin()");
        // $this->setPage($this->login_template);
    }
}

?>