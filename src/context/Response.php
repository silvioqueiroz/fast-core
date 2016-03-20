<?php
namespace fastblocks\core\context;

/**
 *
 * @author Silvio
 *        
 */
class Response
{

    private $files = array();

    private $vars = array();

    function addFile($varname, $filename)
    {
        $this->files[$varname] = $filename;
    }

    function addVar($varname, $value)
    {
        $this->vars[$varname] = $value;
    }

    function files()
    {
        return $this->files;
    }

    function vars()
    {
        return $this->vars;
    }
}

?>