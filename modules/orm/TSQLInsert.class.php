<?php
require_once '../../orm/TSQLInstruction.class.php';
require_once (FAST_PATH . '/orm/function/SQLFunction.class.php');

/**
 * Description of TSQLInsertClass
 *
 * @author Silvio Pereira
 */
final class TSQLInsert extends TSQLInstruction
{
    
    // @override
    public function getInstruction()
    {
        $this->sql = "INSERT INTO {$this->getEntity()} (";
        $columns = implode(', ', array_keys($this->columnValues));
        $values = implode(', ', array_values($this->columnValues));
        $this->sql .= $columns . ')';
        $this->sql .= " values({$values})";
        
        return $this->sql;
    }

    public function setRowData($column, $value)
    {
        if (is_string($value)) {
            $value = addslashes($value);
            $this->columnValues[$column] = "'$value'";
        } else 
            if (is_bool($value)) {
                $this->columnValues[$column] = $value ? 'TRUE' : 'FALSE';
            } else 
                if (isset($value)) {
                    $this->columnValues[$column] = $value;
                } else 
                    if ($value instanceof date) {
                        $this->columnValues[$column] = $value;
                    } else 
                        if (is_object($value)) {
                            $this->columnValues[$column] = $value->id;
                        } else 
                            if ($value instanceof SQLFunction) {
                                $this->columnValues[$column] = $value->value;
                            } else {
                                $this->columnValues[$column] = "NULL";
                            }
    }
    
    // @override
    public function setCriteria($criteria)
    {
        throw new Exception("Cannot call setCriteria from " . __CLASS__);
    }
}
?>
