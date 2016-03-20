<?php
require_once FAST_PATH . '/template/IConfigLoader.class.php';

class ConfigLoader implements IConfigLoader
{

    private $configPath = "app.config/template.xml";

    private $templateClass;

    private $log;

    function __construct($templateClass)
    {
        $this->templateClass = $templateClass;
        $this->log = TLoggerFactory::getLogger();
    }

    function setBase($filename)
    {
        $this->configPath = $filename;
    }

    function loadConfig($page = null)
    {
        if (file_exists($this->configPath)) {
            $this->log->logInfo("Existe file " . $this->configPath);
            // load conf file
            $conf = parse_ini_file($this->configPath);
            if (! empty($conf)) {
                $this->log->logInfo("File " . $this->defaultBase . " not empty.");
                foreach ($conf as $key => $varName) {
                    $this->log->logInfo("KEY " . $key);
                    $this->log->logInfo("varName " . $varName);
                    $this->templateClass->addFile($key, $varName);
                    $this->log->logInfo("KEY " . $key . " configured as " . $varName);
                }
            } else {
                $this->log->logError("File " . $defaultBase . " empty.");
                throw new Exception("File " . $defaultBase . " empty.");
            }
        } else {
            throw new Exception("Arquivo " . $defaultBase . " não encontrado.");
        }
    }
}
?>