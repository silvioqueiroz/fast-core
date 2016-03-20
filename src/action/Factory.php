<?php
namespace fastblocks\core\action;

/**
 * Factory de Command
 * Responsável por retornar o Command que será executado
 *
 * @author Silvio Queiroz
 */
class Factory
{

    static function createAction($actionName)
    {
        // TODO: adicionar log ao factory.
        $sufixAction = "Action";
        $actionName = $actionName . $sufixAction;
        return new $actionName();
    }
}
?>