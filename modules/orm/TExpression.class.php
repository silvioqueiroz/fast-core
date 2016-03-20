<?php

/**
 * 
 * classe TExpression
 * Classe abstrata para gerenciar expressões
 * 
 * @author Silvio Pereira
 * 
 * @last modified 02/27/2011
 */
abstract class TExpression
{

    const AND_OPERATOR = 'AND';

    const OR_OPERATOR = 'OR';

    const EQUAL_OPERATOR = '=';

    abstract public function dump();
}
?>
