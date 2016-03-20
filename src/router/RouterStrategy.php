<?php
namespace fastblocks\core\roter;

/**
 * Type of strategy to resolve the action and method the router request.
 *
 * @author Silvio
 *        
 */
interface RouterStrategy
{

    function createAction();
}

?>