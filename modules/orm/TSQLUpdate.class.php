<?php

/**
 * Description of TSQLInsert
 *
 * @author Silvio Pereira
 */
class TSQLUpdate extends TSQLInstruction
{

    /*
     * function __autoload($classe) {
     * $file = ''.$classe.'.class.php';
     * if (file_exists($file)) {
     * require_once $file;
     * }else {
     * echo "not exist {$file}";
     * }
     * }
     */
    public function getInstruction()
    {
        $this->sql = "UPDATE {$this->getEntity()}";
        
        if ($this->columnValues) {
            foreach ($this->columnValues as $column => $value) {
                $set[] = "{$column} = {$value}";
            }
        }
        $this->sql .= ' SET ' . implode(', ', $set);
        
        if ($this->criteria) {
            $this->sql .= ' WHERE ' . $this->getCriteria()->dump();
        }
        
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
                } else {
                    $this->columnValues[$column] = 'NULL';
                }
    }
}
?>
