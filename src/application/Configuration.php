<?php
namespace fastblocks\core\application;

class Configuration
{

    const APP = "";

    const SITE = "http://.com/pre";

    const SEND_PER_HOUR = 50;
    
    // #Template configuration.
    // const TEMPLATE_CLASS = "AdvancedTemplate";
    const TEMPLATE_CLASS = "SmartyTemplate";

    const TEMPLATE_DIR = 'app.template';

    const CONFIG_DIR = 'app.config';

    const CACHE_DIR = 'app.cache';
    
    // use
    const APPLICATION_DIR = '/var/www/cond';

    static function CONNECTION_PROPERTIES()
    {
        return array(
            'user' => 'root',
            'pass' => '',
            'host' => 'localhost',
            'name' => 'empregada',
            'type' => 'mysql'
        );
    }

    static function LOG_PROPERTIES()
    {
        return array(
            'level' => 'INFO',
            'type' => 'TLoggerTXT',
            'path' => 'log/log.log'
        );
    }

    static function STRATEGY_PROPERTIES()
    {
        return InnerActionStrategy;
        // return SampleStrategy;
    }

    static function CHARSET_PROPERTIES()
    {
        return 'iso-8859-1';
    }

    static function ERROR_REPORTING()
    {
        return E_ALL & ~ E_NOTICE;
    }

    static function FILTER_LIST()
    {
        return array();
        // 'XSSFilter'
        
    }
}

?>
