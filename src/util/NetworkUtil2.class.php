<?php

class NetworkUtil
{

    static function getHostIP()
    {
        $hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        return gethostbyname($hostname);
    }
}