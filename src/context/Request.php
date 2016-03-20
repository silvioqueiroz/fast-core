<?php
namespace fastblocks\core\context;

class Request extends Context
{

    protected $session_key = null;

    protected $get_context = null;

    protected $post_context = null;

    protected $session_context = null;

    protected $input = null;

    function __construct()
    {
        // TODO: rever como será tratado o session_key
        // $this->session_key = TitanConstants::LOGIN_CLIENT;
        $this->get_context = new Context($_GET);
        $this->post_context = new Context($_POST);
        $this->session_context = new Context($_SESSION);
        $this->input = new Context($_REQUEST);
    }
}

?>