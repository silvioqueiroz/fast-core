<?php
namespace fastblocks\modules\logger;

/**
 * Description of TLoggerclass
 *
 * @author Silvio Pereira
 */
abstract class Log
{

    const INFO = "INFO";

    const DEBUG = "DEBUG";

    const WARN = "WARN";

    const ERROR = "ERROR";

    const FATAL = "FATAL";

    protected $filename;

    protected $level;

    protected $clazz;

    function __construct($filename, $clazz = null)
    {
        $this->filename = $filename;
        $this->clazz = $clazz;
    }

    protected abstract function write($message);

    public function setClazz($clazz)
    {
        $this->clazz = $clazz;
    }

    public function setLevel($level)
    {
        $this->level = $level;
    }

    function isDebug()
    {
        return $this->level == self::DEBUG || $this->isWarn();
    }

    function isInfo()
    {
        return $this->level == self::INFO || $this->isDebug();
    }

    function isWarn()
    {
        return $this->level == self::WARN;
    }

    function logError($message)
    {
        $this->write(self::ERROR . " :: " . $message);
    }

    function logFatal($message)
    {
        $this->write(self::FATAL . " :: " . $message);
    }

    function logInfo($message)
    {
        if ($this->isInfo())
            $this->write(self::INFO . " :: " . $message);
    }

    function logWarn($message)
    {
        if ($this->isWarn())
            $this->write(self::WARN . " :: " . $message);
    }

    function logDebug($message)
    {
        if ($this->isDebug())
            $this->write(self::DEBUG . " :: " . $message);
    }
}
?>
