<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HibernateProxyclass
 *
 * @author Silvio Pereira
 */
class HibernateProxy
{

    private $object;

    public function __construct($object)
    {
        $this->object = $object;
    }

    public function __get($name)
    {
        if (method_exists($object, "get$name")) {
            if ($this->object[$name]) {
                return $this->object[$name];
            } else {
                return get_class($object);
            }
        }
    }
}
?>
