<?php
require_once '../../orm/TConnection.class.php';

/**
 * Description of TTransaction
 *
 * @author Silvio Pereira
 */
final class TTransaction
{

    private static $conn;

    private static $logger;

    const CONNECTION = "connection";

    private function __construct()
    {}

    public static function open($database)
    {
        if (empty(self::$conn)) {
            self::$conn = TConnection::open(self::CONNECTION);
            self::$conn->beginTransaction();
        }
    }

    public static function get()
    {
        return self::$conn;
    }

    public static function rollback()
    {
        self::$conn->rollBack();
    }

    public static function close()
    {
        self::$conn->commit();
        self::$conn = NULL;
    }

    public static function setLogger(TLogger $logger)
    {
        self::$logger = $logger;
    }

    public static function log($message)
    {
        if (self::$logger) {
            self::$logger->write($message);
        } else {
            throw new Exception("logger null");
        }
    }
}
?>
