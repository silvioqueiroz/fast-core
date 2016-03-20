<?php
namespace fastblocks\logger;

/**
 * Description of TLoggerTXTclass
 *
 * @author Silvio Pereira
 */
class TLoggerTXT extends Log
{

    protected function write($message)
    {
        $time = date("y-m-d H:i:s");
        $text = "$time :: " . $this->clazz . " :: $message \t\n";
        $handler = fopen($this->filename, 'a');
        fwrite($handler, $text);
        fclose($handler);
    }
}
?>
