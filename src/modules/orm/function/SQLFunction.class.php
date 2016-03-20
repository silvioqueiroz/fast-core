<?php

class SQLFunction
{

    const NOW = "now()";

    private $value;

    function __construct($value)
    {
        $this->value = $value;
    }

    function value()
    {
        return $this->value;
    }

    function __toString()
    {
        return $this->value();
    }
}

?>