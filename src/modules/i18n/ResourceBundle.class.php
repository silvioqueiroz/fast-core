<?php

class ResourceBundle
{

    private $resource;

    function __construct($resource)
    {
        $this->resource = $resource;
    }

    function getMessage($key)
    {
        $text = $this->resource[$key];
        if ($text == null) {
            $text = $key;
        }
        return $text;
    }
}
?>