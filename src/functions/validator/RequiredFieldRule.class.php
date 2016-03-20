<?php

/**
 * 
 * Regra de obrigatoriedade.
 * 
 * Tem como padrão INPUT_POST.
 * 
 * @author Silvio Pereira
 *
 */
class RequiredFieldRule implements Rule
{

    const MESSAGE = "E-Mail is not valid";

    private $input;

    private $name;

    private $message;

    function __construct($name, $input = INPUT_POST, $message = self::MESSAGE)
    {
        $this->input = $input;
        $this->name = $name;
        $this->message = $message;
    }

    function validate()
    {
        if (! filter_input($this->input, $this->name, FILTER_VALIDATE_EMAIL)) {
            return $this->message;
        }
    }
}
?>