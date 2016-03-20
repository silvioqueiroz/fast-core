<?php

/**
 * 
 * Enter description here ...
 * @author Silvio Queiroz
 *
 */
class MamCachedSuportImpl implements MamCachedSuport
{

    private $memcache;

    function __construct()
    {
        $this->memcache = new Memcache();
    }

    function setCache($key, $object, $timeout = 60)
    {
        return ($memcache) ? $memcache->set($key, $object, MEMCACHE_COMPRESSED, $timeout) : false;
    }

    function getCache($key)
    {
        return ($memcache) ? $memcache->get($key) : false;
    }

    function getVersion()
    {
        $version = $memcache->getVersion();
        return "Server's version: " . $version . "<br/>\n";
    }

    function connect(String $host, int $port)
    {
        $memcache->connect($host, port) or new Exception("Could not connect");
    }
}

?>