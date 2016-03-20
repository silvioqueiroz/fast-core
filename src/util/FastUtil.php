<?php
namespace fastblocks\core\util;

class FastUtil
{

    /**
     * Verifica se o objeto ou a propriedade do objeto é nullo ou vazio.
     *
     * @param unknown $_object            
     * @param unknown $_prop            
     */
    static function isEmptyOrNull($_object, $_prop)
    {
        return isset($_object[$_prop]) ? ($_object[$_prop] == null && $_object[$_prop] == "") : true;
    }

    static function endsWith($str, $sub)
    {
        return (substr($str, strlen($str) - strlen($sub)) == $sub);
    }
    
    /*
     * static function ends( $str, $sub ) {
     * return substr( $str, strlen( $str ) - strlen( $sub ) );
     * }
     *
     * static function beginsWith( $str, $sub ) {
     * return ( substr( $str, 0, strlen( $sub ) ) == $sub );
     * }
     */
}
?>