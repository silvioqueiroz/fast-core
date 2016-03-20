<?php
require_once FAST_PATH . '/core/AdvancedAction.class.php';

class OutherException extends AdvancedAction
{

    public function __construct()
    {
        parent::__construct();
        session_start();
    }

    public function process()
    {
        $this->setPage("error");
    }
}

?>