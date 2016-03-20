<?php

/**
 * Description of TCriteria
 *
 * @author Silvio Pereira
 */
require_once (FAST_PATH . '/orm/TExpression.class.php');

class TCriteria extends TExpression
{

    private $expressions;

    private $operators;

    private $properties;

    public function add(TExpression $expression, $operator = self::AND_OPERATOR)
    {
        if (empty($this->expressions)) {
            unset($operator);
        }
        $this->expressions[] = $expression;
        $this->operators[] = $operator;
    }

    public function dump()
    {
        if (is_array($this->expressions)) {
            foreach ($this->expressions as $i => $expression) {
                $operator = $this->operators[$i];
                $result .= $operator . ' ' . $expression->dump() . ' ';
            }
        }
        
        $result = trim($result);
        return "({$result})";
    }

    public function getExpressions()
    {
        return $this->expressions;
    }

    public function setExpressions($expressions)
    {
        $this->expressions = $expressions;
    }

    public function getOperators()
    {
        return $this->operators;
    }

    public function setOperators($operators)
    {
        $this->operators = $operators;
    }

    public function getProperties($propertie)
    {
        return $this->properties[$propertie];
    }

    public function setProperties($propertie, $value)
    {
        $this->properties[$propertie] = $value;
    }
}
?>
