<?php

class DateTimeCompatibility extends DateTime
{

    /*
     * public function __construct ($time = null, DateTimeZone $timezone = null) {
     * if ($time && $timezone)
     * parent::__construct($time, $timezone);
     * elseif ($time)
     * parent::__construct($time);
     * else
     * parent::__construct();
     * }
     */
    public function getTimestamp()
    {
        return method_exists('DateTime', 'getTimestamp') ? parent::getTimestamp() : $this->format('U');
    }
}
?>
