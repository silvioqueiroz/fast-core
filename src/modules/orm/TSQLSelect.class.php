<?php

/**
 * Description of TSQLInsertClass
 *
 * @author Silvio Pereira
 */
require_once (FAST_PATH . '/orm/TSQLInstruction.class.php');

class TSQLSelect extends TSQLInstruction
{

    private $logger;

    private $columns;
    // array de colunas a serem retornadas
    function __construct()
    {
        $this->logger = TLoggerFactory::getLogger();
    }

    /**
     * adiciona uma coluna a ser retornada pelo SELECT
     *
     * @param $column =
     *            coluna da tabela
     */
    public function addColumn($column)
    {
        // adiciona a coluna no array
        $this->columns[] = $column;
    }

    /**
     * retorna a instrução de SELECT em forma de string.
     */
    public function getInstruction()
    {
        // monta a instrução de SELECT
        $this->sql = 'SELECT ';
        // monta a string com os nomes de colunas
        $this->sql .= implode(', ', $this->columns);
        // adiciona na cláusula FROM o nome da tabela
        $this->sql .= ' FROM ' . $this->getEntity();
        
        // obtém a cláusula WHERE do objeto criteria.
        if ($this->criteria) {
            $expression = $this->criteria->dump();
            // FIXME: melhorar lógica
            if ($expression && $expression != '()') {
                $this->sql .= ' WHERE ' . $expression;
            }
            // obtem as propriedades do criterio
            $order = $this->criteria->getProperties('order');
            $limit = $this->criteria->getProperties('limit');
            $offset = $this->criteria->getProperties('offset');
            
            // obtem a ordenação do SELECT
            if ($order) {
                $this->sql .= ' ORDER BY ' . $order;
            }
            if ($limit) {
                $this->sql .= ' LIMIT ' . $limit;
            }
            if ($offset) {
                $this->sql .= ' OFFSET ' . $offset;
            }
        }
        // FIXME: adicionar flag para habilitar desabilitar exibir sql
        $this->logger->logInfo("SHOW-SQL :: {$this->sql}.");
        
        return $this->sql;
    }
}
?>
