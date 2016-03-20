<?php

Interface MamCachedSuport
{

    /**
     *
     * Enter description here ...
     *
     * @param unknown_type $key            
     * @param unknown_type $object            
     * @param unknown_type $timeout            
     */
    function setCache($key, $object, $timeout = 60);

    /**
     *
     * Enter description here ...
     *
     * @param unknown_type $key            
     */
    function getCache($key);

    /**
     * Enter description here .
     * ..
     */
    function getVersion();

    /**
     *
     * Enter description here ...
     *
     * @param unknown_type $host            
     */
    function connect(String $host, int $port);
}

?>