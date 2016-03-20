<?php

class AuctionResponse
{

    protected $data;

    public function __construct($id = null)
    {
        $this->logger = TLoggerFactory::getLogger();
        if ($id != null) {
            $object = $this->load($id);
            if ($object) {
                $this->fromArray($object->toArray());
            }
        }
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

    public function toArray()
    {
        return $this->data;
    }
}

?>