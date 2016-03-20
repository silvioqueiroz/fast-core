<?php

/**
 * 
 * Classe utilitaria para manipulaçao de formularios
 * 
 * @author Silvio Pereira
 *
 */
class FormUtil
{

    const ACTION_PARAMETTER = "action";

    const MODULE_PARAMETTER = "module";

    /**
     *
     * Retorna um model populado a partir do response do POST
     *
     * @param TRecord $record            
     * @param array $exception            
     */
    static function postToModel(TRecord $record, array $exception = null)
    {
        if ($exception == null) {
            $exception = array();
        }
        $exception[] = self::ACTION_PARAMETTER;
        $exception[] = self::MODULE_PARAMETTER;
        
        foreach ($_POST as $key => $value) {
            echo "array[$key] = $value";
            if (! in_array($key, $exception)) {
                $record->$key = $value;
            }
        }
        return $record;
    }
}