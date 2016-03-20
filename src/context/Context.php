<?php

/**
 * Class of the handler $_GET $_POST and $_REQUEST.
 *
 * PHP VERSION 5.5
 *
 * @category Production
 * @package  Context
 * @author   Silvio Queiroz <silvio.queiroz@gmail.com>
 * @license  http://fastbuildingblocks.com/license.txt free-bsd
 * @link     http://fastbuildingblocks.com
 */
namespace fastblocks\core\context;

use fastblocks\core\util\FastUtil;

// require_once FAST_PATH.'/util/FastUtil.class.php';

/**
 * Class of the handler $_GET $_POST and $_REQUEST.
 *
 * PHP VERSION 5.5
 *
 * @category Production
 * @package Context
 * @author Silvio Queiroz <silvio.queiroz@gmail.com>
 * @license http://fastbuildingblocks.com/license.txt free-bsd
 * @link http://fastbuildingblocks.com
 */
class Context
{

    protected $source;

    /**
     * Contruct of Context Class.
     *
     * @param unknown_type $_source
     *            $_REQUEST
     */
    public function __construct($_source)
    {
        $this->source = $_source;
    }
    // end __construct()
    
    /**
     * Get parametter of Request.
     *
     * @param unknown_type $obj
     *            Array of request.
     * @param unknown_type $prop
     *            Property name
     *            
     * @return Ambigous <NULL, unknown> value of property in the request.
     */
    public function parametter($obj, $prop)
    {
        if (FastUtil::isEmptyOrNull($obj, $prop) === true) {
            return null;
        } else {
            return $obj[$prop];
        }
    }
    // end parametter()
    
    /**
     * Magic method get of request.
     *
     * @param unknown_type $_prop
     *            property name
     *            
     * @return mixed|NULL value of property
     */
    public function __get($_prop)
    {
        if (method_exists($this, 'get_' . $_prop) === true) {
            return call_user_func(array(
                $this,
                'get_' . $_prop
            ));
        } else 
            if (FastUtil::isEmptyOrNull($this->_source, $_prop) === true) {
                return null;
            } else {
                return $this->source[$_prop];
            }
    }
    // end __get()
    
    /**
     * Magic method set.
     *
     * @param unknown_type $_prop
     *            property name
     * @param unknown_type $value
     *            property value
     *            
     * @return void
     */
    public function __set($_prop, $value)
    {
        if (method_exists($this, 'set_' . $_prop) === true) {
            call_user_func(array(
                $this,
                'set_' . $_prop
            ), $value);
        } else {
            $this->source[$_prop] = $value;
        }
    } // end __set()
} // end class

?>
