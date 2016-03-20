<?php
require_once FAST_PATH . "/util/FastUtil.class.php";

function __autoload($class)
{
    // echo "class name ". $class."<br/>";
    if (! is_null($class) && ! empty($class)) {
        // TODO: Criar estrategia para cada pasta... e usando ends
        if (FastUtil::endsWith($class, 'Record')) {
            $path = 'app.model/recorder/';
        } elseif (FastUtil::endsWith($class, 'Repository')) {
            $path = 'app.model/repository/';
        } elseif (FastUtil::endsWith($class, 'Business')) {
            $path = 'app.business/';
        } elseif (FastUtil::endsWith($class, 'Exception')) {
            $path = 'app.exception/';
        } elseif (FastUtil::endsWith($class, 'Widget')) {
            $path = 'app.widget/';
        } elseif (FastUtil::endsWith($class, 'Strategy')) {
            $path = FAST_PATH . "/strategy/";
        } elseif (FastUtil::endsWith($class, 'Template')) {
            $path = FAST_PATH . "/template/";
        } elseif (FastUtil::endsWith($class, 'Filter')) {
            $path = 'app.filter/';
        } elseif (FastUtil::beginsWith($class, 'Smarty')) {
            $path = FAST_PATH . "/libs/sysplugins/" . strtolower($class) . ".php";
        } else {
            $path = FAST_PATH;
        }
        if (! FastUtil::endsWith($path, ".php")) {
            $path .= "/$class.class.php";
        }
        // echo "<b>path</b> ".$path."<br/>";
        include $path;
    }
}
?>