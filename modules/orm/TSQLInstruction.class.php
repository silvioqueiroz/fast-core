<?php
require_once ('app.config/ApplicationContext.class.php');

abstract class TSQLInstruction
{

    protected $sql;

    protected $criteria;

    final public function setEntity($entity)
    {
        $this->entity = $entity;
    }

    final public function getEntity()
    {
        return strtolower(ApplicationContext::APP . $this->entity);
    }

    public function getCriteria()
    {
        return $this->criteria;
    }

    public function setCriteria($criteria)
    {
        $this->criteria = $criteria;
    }

    public abstract function getInstruction();
}
?>
