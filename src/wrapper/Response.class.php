<?php

class Response
{

    private $data;

    const CODE_FIELD = 'CODE';

    const VALUE_FIELD = 'VALUE';

    public function __construct($code = null, $value = null)
    {
        $data = array();
        $this->setResponse($code, $value);
    }

    public function setResponse($code, $value = null)
    {
        $this->data[self::CODE_FIELD] = $code;
        if ($value != null)
            $this->data[self::VALUE_FIELD] = $value;
    }

    public function toArray()
    {
        return $this->data;
    }

    public function __set($prop, $value)
    {
        $this->data[strtoupper($prop)] = $value;
    }

    public function __get($prop)
    {
        $prop = strtoupper($prop);
        return $this->data[$prop];
    }

    public function fromArray($data)
    {
        $this->data = $data;
    }
}
?>