<?php

class SendMail
{

    private $destinatario = null;

    private $assunto = null;

    private $corpo = null;

    private $headers = null;

    function __construct($destinatario, $assunto, $corpo)
    {
        $this->destinatario = $destinatario; // = "silvio.queiroz@homework.net";
        $this->assunto = $assunto; // = "Esta mensagem é um teste";
        $this->corpo = $corpo;
        
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html;
		charset=iso-8859-1\r\n";
        
        // endereço do remetente
        $headers .= "From: Adkira <postmaster@homework.net>\r\n";
        
        // endereço de resposta, se queremos que seja diferente a do remetente
        $headers .= "Reply-To: adkira@homework.net\r\n";
        
        $this->headers = $headers;
    }

    function send()
    {
        mail($this->destinatario, $this->assunto, $this->corpo, $this->headers);
    }
}
?>
