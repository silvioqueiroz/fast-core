<?php
/**
 * Esta classe provê uma interface para definição de filtros de seleção.
 *
 * @author Silvio Pereira
 * 
 * @last modified 02/27/2011
 */
require_once (FAST_PATH . '/orm/TExpression.class.php');

class TFilter extends TExpression
{

    private $variable;

    private $operator;

    private $value;

    function __construct($variable, $operator, $value)
    {
        $this->variable = $variable;
        $this->operator = $operator;
        $this->value = $this->transform($value);
    }

    public function getVariable()
    {
        return $this->variable;
    }

    public function setVariable($variable)
    {
        $this->variable = $variable;
    }

    public function getOperator()
    {
        return $this->operator;
    }

    public function setOperator($operator)
    {
        $this->operator = $operator;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    private function transform($value)
    {
        if (is_array($value)) {
            foreach ($value as $x) {
                if (is_integer($x)) {
                    $foo[] = $x;
                } else 
                    if (is_string($x)) {
                        $foo[] = "'$x'";
                    }
            }
            $result = '(' . implode(',', $foo) . ')';
        } else 
            if (is_string($value)) {
                $result = "'$value'";
            } else 
                if (is_null($value)) {
                    $result = 'NULL';
                } else 
                    if (is_bool($value)) {
                        $result = $value ? 'TRUE' : 'FALSE';
                    } else {
                        $result = $value;
                    }
        return $result;
    }

    public function dump()
    {
        return "{$this->variable} {$this->operator} {$this->transform_to_string($this->value)}";
    }

    private function transform_to_string($value)
    {
        if ($value instanceof TSQLInstruction) {
            return "({$value->getInstruction()})";
        } else {
            return $value;
        }
    }
}
?>
