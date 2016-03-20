<?php
require_once (FAST_PATH . '/orm/TSQLInsert.class.php');
require_once (FAST_PATH . '/orm/TSQLUpdate.class.php');
require_once (FAST_PATH . '/orm/TSQLSelect.class.php');
require_once (FAST_PATH . '/orm/TSQLDelete.class.php');
require_once (FAST_PATH . '/orm/TCriteria.class.php');
require_once (FAST_PATH . '/orm/TFilter.class.php');
require_once (FAST_PATH . '/functions/Functions.class.php');

abstract class TRecord
{

    const SUFIX = 'Record';

    protected $data;

    protected $logger;

    function __autoload($class)
    {
        Application::autoLoad($class);
    }

    public function __construct($id = null)
    {
        $this->logger = TLoggerFactory::getLogger();
        $this->logger->logInfo('id  = ' . $id);
        if ($id != null) {
            $object = $this->load($id);
            if ($object) {
                $this->fromArray($object->toArray());
            }
        }
    }

    public function __clone()
    {
        unset($this->id);
    }

    public function __set($prop, $value)
    {
        if (method_exists($this, 'set_' . $prop)) {
            call_user_func(array(
                $this,
                'set_' . $prop
            ), $value);
        } else {
            $this->data[strtoupper($prop)] = $value;
        }
    }

    public function __get($prop)
    {
        // $this->logger->loginfo("get ". $prop);
        if (method_exists($this, 'get_' . $prop)) {
            call_user_func(array(
                $this,
                'get_' . $prop
            ));
        }  // conversão de lazy load
          // else if (Functions::contains($prop, "_id") || Functions::contains($prop, "_list"))
          // {
          // if (!$this->data[$prop] && !is_object($this->data[$prop]))
          // {
          // $arrayNames = explode("_", $prop);
          // $className = ucfirst($arrayNames[0]);
          // $className .= "Record";
          // require_once "app.model/recorder/{$className}.class.php";
          // $class = new $className($this->data[$prop]);
          // $this->data[$prop] = $class;
          // return $class;
          // }
          // else
          // {
          // return $this->data[$prop];
          // }
          // }
        else {
            $prop = strtoupper($prop);
            return $this->data[$prop];
        }
    }

    public function getEntity()
    {
        $class = strtolower(get_class($this));
        return substr($class, 0, - 6);
    }

    public function fromArray($data)
    {
        $this->data = $data;
        // foreach ($this->data as $key => $value)
        // {
        // $array[$key] = setRowData($key, $value);
        // }
        // $this->data = $array;
    }

    public function setRowData($column, $value)
    {
        if ($this->isFK($column) && ! is_object($value)) {
            $className = substr($column, - 4) . "Record";
            $class = new $className($value->id);
            return $class;
        } else {
            return $value;
        }
    }

    public function isFK($column)
    {
        $prefixo = substr($class, 0, 4);
        return $prefixo == "REF_";
    }

    public function toArray()
    {
        return $this->data;
    }

    public function store()
    {
        // verifica se tem ID ou se existe na base de dados
        if (empty($this->data['ID']) or (! $this->load($this->id))) {
            // cria a chave a ausenco de sequecia ou auto-incremento.
            // $this->id = $this->last() + 1;
            $sql = new TSQLInsert();
            $sql->setEntity($this->getEntity());
            // percorre os dados do object
            foreach ($this->data as $key => $value) {
                $sql->setRowData($key, $value);
            }
        } else {
            // instrução de update
            $sql = new TSQLUpdate();
            $sql->setEntity($this->getEntity());
            // cria o criterio de selecao baseado no id
            $criteria = new TCriteria();
            $criteria->add(new TFilter('id', '=', $this->id));
            $sql->setCriteria($criteria);
            // precorre os dados do objeto
            foreach ($this->data as $key => $value) {
                if ($key !== 'id') // o ID nao precida ir no update
{
                    // passa os dados do object para o SQL
                    $sql->setRowData($key, $value);
                }
            }
        }
        // obtem a transação ativa
        if ($conn = TTransaction::get()) {
            // faz o log e executa
            $result = $conn->exec($sql->getInstruction());
            $this->logger->logInfo("SHOW-SQL::: {$sql->getInstruction()}");
            if ($this->id == null) {
                $result = $this->getLast();
                return $result;
            } else {
                return $this;
            }
        } else {
            // se não tiver transação, retorna uma execeção
            throw new Exception("Não há transação ativa!");
        }
    }

    private function getLast()
    {
        $sql_last_insert = "SELECT LAST_INSERT_ID()";
        $this->logger->logInfo("SHOW-SQL::: SELECT LAST_INSERT_ID()");
        if ($conn = TTransaction::get()) {
            // registra mensagem de log
            
            // executa instrução de SELECT
            $result = $conn->Query($sql_last_insert);
            if ($result) {
                $row = $result->fetch();
            }
            // retorna o resultado
            $id = $row[0];
            $this->logger->logInfo("LOG ::::: valor de id retornado $id");
            return $this->load($id);
        } else {
            // se não houver transação, retorna exceção
            throw new Exception('Não há transação ativa!');
        }
    }

    public function load($id)
    {
        // instancia instrução de SELECT
        $sql = new TSQLSelect();
        $sql->setEntity($this->getEntity());
        $sql->addColumn('*');
        // cria critério de seleção baseado no ID
        $criteria = new TCriteria();
        $criteria->add(new TFilter('id', '=', $id));
        $sql->setCriteria($criteria);
        // obtem transação ativa
        if ($conn = TTransaction::get()) {
            // cria mensagem de log e executa a consulta
            $result = $conn->Query($sql->getInstruction());
            // se retornou algum dado
            if ($result) {
                // retorna os dados em forma de objeto
                $object = $result->fetchObject(get_class($this));
            }
            return $object;
        } else {
            // se não tiver transação, retorna uma execeção
            throw new Exception("Não há transação ativa!");
        }
    }

    public function delete($id = null)
    {
        // o ID é o parâmetro ou a propriedade ID
        $id = $id ? $id : $this->id;
        // instancia uma instrução de DELETE
        $sql = new TSQLDelete();
        $sql->setEntity($this->getEntity());
        
        // cria critério de seleção de dados
        $criteria = new TCriteria();
        $criteria->add(new TFilter('id', '=', $id));
        // define o criterio de selecao baseado no id
        $sql->setCriteria($criteria);
        $this->logger->logInfo("SHOW-SQL:: " + $sql->getInstruction());
        // obtem a transação ativa
        if ($conn = TTransaction::get()) {
            // faz o log e executa o SQL
            $this->logger->logInfo("SHOW-SQL:: " + $sql->getInstruction());
            $result = $conn->exec($sql->getInstruction());
            // retorna o resultado
            return $result;
        } else {
            // se não tiver transação, retorna uma execão
            throw new Exception('Não há transação ativa!!');
        }
    }

    public function loadALL()
    {
        // instancia instrução de SELECT
        $sql = new TSQLSelect();
        $sql->setEntity($this->getEntity());
        $sql->addColumn('*');
        // obtem transação ativa
        if ($conn = TTransaction::get()) {
            // cria mensagem de log e executa a consulta
            $result = $conn->Query($sql->getInstruction());
            // se retornou algum dado
            if ($result) {
                // retorna os dados em forma de objeto
                $object = $result->fetchObject(get_class($this));
            }
            return $object;
        } else {
            // se não tiver transação, retorna uma execeção
            throw new Exception("Não há transação ativa!");
        }
    }

    public function loadQuery($query)
    {
        
        // obtem transação ativa
        if ($conn = TTransaction::get()) {
            // cria mensagem de log e executa a consulta
            $result = $conn->Query($query);
            // se retornou algum dado
            if ($result) {
                // retorna os dados em forma de objeto
                $object = $result->fetchObject(get_class($this));
            }
            return $object;
        } else {
            // se não tiver transação, retorna uma execeção
            throw new Exception("Não há transação ativa!");
        }
    }

    public function __toString()
    {
        $source = "";
        foreach ($this->data as $key => $value) {
            // passa os dados do object para o SQL
            $source .= "[$key => $value]";
        }
        return $source;
    }
}

?>
