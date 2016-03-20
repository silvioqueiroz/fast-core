<?php
require_once FAST_PATH . '/template/Template.class.php';
require_once FAST_PATH . '/template/ConfigLoader.class.php';
require_once FAST_PATH . '/template/XMLConfigLoader.class.php';

class AdvancedTemplate extends Template
{

    /**
     * Regular expression to find var i18n.
     *
     * Only alfa-numeric chars and the underscore char are allowed.
     *
     * @var string
     */
    protected static $REG_NAME_I18N = "i18n:([[:alnum:]]|_)+";

    private $_page;

    private $configLoader;

    protected $defaultBase = "app.template/main/base.html";

    function setPage($page)
    {
        $this->_page = $page;
        $this->configLoader->loadConfig($this->_page);
    }

    function __construct($defaultBase)
    {
        parent::__construct($this->defaultBase);
        $this->configLoader = new XMLConfigLoader($this);
    }

    /**
     * identifica a localização de arquivo de configuração.
     *
     * @param unknown_type $path            
     */
    function file_path($path)
    {
        $this->configLoader->setBase($path);
    }

    /**
     * Retorna o conteúdo final, sem mostrá-lo na tela.
     * Se você quer mostrá-lo na tela, use o método Template::show().
     *
     * @return string
     */
    public function parse()
    {
        $r = preg_match_all("/{(" . self::$REG_NAME_I18N . ")((\-\>(" . self::$REG_NAME_I18N . "))*)?}/", $this->subst("."), $matches);
        if ($r) {
            for ($i = 0; $i < $r; $i ++) {
                // Object var detected
                if ($matches[3][$i] && (! array_key_exists($matches[1][$i], $this->properties) || ! in_array($matches[3][$i], $this->properties[$matches[1][$i]]))) {
                    $this->properties[$m[1][$i]][] = $m[3][$i];
                }
                if (! $this->values["{" . $m[1][$i] . "}"]) {
                    $txt = $matches[3][$i];
                    $array = explode(":", $matches[1][$i]);
                    $key = $array[1];
                    $this->setValue($matches[1][$i], $this->getMessage($key));
                }
            }
        }
        
        // After subst, remove empty vars
        return preg_replace("/{(" . Template::$REG_NAME . ")((\-\>(" . Template::$REG_NAME . "))*)?}/", "", $this->subst(".")); // $this->subst(".");
    }

    function getMessage($key, $locale = null)
    {
        if ($locale == null && $_SESSION["Locale"] == null) {
            $resourceBundle = ResourceBundleFactory::getResourceBundle();
        } else 
            if ($locale == null) {
                $resourceBundle = ResourceBundleFactory::getResourceBundle($_SESSION["Locale"]);
            } else {
                $resourceBundle = ResourceBundleFactory::getResourceBundle($locale);
            }
        return $resourceBundle->getMessage($key);
    }
}

?>