<?php
require_once FAST_PATH . '/template/IConfigLoader.class.php';

class XMLConfigLoader implements IConfigLoader
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

    function loadConfig($page = "base")
    {
        $findedPage = false;
        $this->log->logInfo("Loading template definitions.");
        if (file_exists($this->configPath)) {
            $this->log->logInfo("Exist file " . $this->configPath . ".");
            // load conf file
            $xml = new SimpleXMLElement(file_get_contents($this->configPath));
            if (! empty($xml)) {
                $this->log->logInfo("File " . $this->configPath . " not empty.");
                // $this->log->logInfo("Loading xml content: \n ".file_get_contents($this->configPath));
                // iterator page
                foreach ($xml->children() as $child) {
                    if ($child["id"] != $page) {
                        continue;
                    }
                    $this->log->logInfo("Page $page findedPage = $findedPage .");
                    $findedPage = true;
                    $this->log->logInfo("PAGE id = " . $page . " finded.");
                    // load base template
                    $this->log->logInfo("Loading BASE page.");
                    $this->templateClass->loadfile(".", "" . $child->base);
                    $this->log->logInfo("ELEMENT BASE configured as " . $child->base);
                    foreach ($child->parts->children() as $part) {
                        $this->templateClass->addFile($part->getName(), "" . $part);
                        $this->log->logInfo("ELEMENT " . $part->getName() . " configured as " . $part);
                    }
                    $this->log->logInfo("Load SUCESSFULL template definitions.");
                    break;
                }
                if ($findedPage == false) {
                    $this->log->logError("Page " . $page . " not finded.");
                    throw new Exception("Page " . $page . " not finded.");
                }
            } else {
                $this->log->logError("File " . $this->configPath . " empty.");
                throw new Exception("File " . $this->configPath . " empty.");
            }
        } else {
            $this->log->logError("File " . $this->configPath . " not finded.");
            throw new Exception("File " . $this->configPath . " not finded.");
        }
    }
}
?>