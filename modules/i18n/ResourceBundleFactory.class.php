<?php

class ResourceBundleFactory
{

    const DEFAULT_LOCALE = "pt-BR";

    private static $configPath = "app.resource/";

    private static $fileExtension = ".ini";

    /*
     * public function __autoload($nameClass){
     * require_once FAST_PATH."/i18n/$nameClass.class.php";
     * }
     */
    public static function getResourceBundle($locale = self::DEFAULT_LOCALE)
    {
        if (file_exists(ResourceBundleFactory::$configPath . $locale . ResourceBundleFactory::$fileExtension)) {
            // load conf file
            $resource = parse_ini_file(ResourceBundleFactory::$configPath . $locale . ResourceBundleFactory::$fileExtension);
            // create resource
            $resourceBundle = new ResourceBundle($resource);
            return $resourceBundle;
        } else {
            throw new Exception("Arquivo " . ResourceBundleFactory::$configPath . $locale . ResourceBundleFactory::$fileExtension . " não encontrado");
        }
    }
}

?>