<?php

class RequestUtil
{

    function getParametter($prop)
    {
        return $_GET[$prop];
    }

    function getParametters()
    {
        return $_GET;
    }

    /**
     */
    function populateBean(TRecord $record, string $method)
    {
        // verifica se o bean é nulo
        if ($record == NULL) {
            throw new Exception("This record bean can't be null!");
        }
        if ($method != NULL && $method == RequestConstants::POST) {
            $record->fromArray($_POST);
        } else {
            $record->fromArray($_GET);
        }
    }
}

?>