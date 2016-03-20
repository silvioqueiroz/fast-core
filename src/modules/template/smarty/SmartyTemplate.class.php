<?php
namespace fastblocks\core\modules\template\smarty;

use ErrorException;
require_once __DIR__ . '/../../../vendor/autoload.php';
// require_once FAST_PATH.'/libs/Smarty.class.php';
class SmartyTemplate
{

    private $smarty;

    private $_page;

    function __construct($page)
    {
        $this->_page = $page;
        $this->smarty = new \Smarty();
        // $smarty->force_compile = true;
        $this->smarty->debugging = false;
        $this->smarty->caching = 0;
        $this->smarty->cache_lifetime = 10;
        $this->smarty->setTemplateDir('app.template')
            ->setCacheDir('app.cache')
            ->setConfigDir('app.config');
    }

    function show()
    {
        $this->smarty->display($this->_page);
    }

    function addFile($varname, $filename)
    {
        new ErrorException("Not supotted yet!");
    }

    public function __set($varname, $value)
    {
        $this->smarty->assign($varname, $value);
    }

    public function loadfile($varname, $filename)
    {
        new ErrorException("Not supotted yet!");
    }

    public function setPage($page)
    {
        $this->_page = $page;
    }
}
?>