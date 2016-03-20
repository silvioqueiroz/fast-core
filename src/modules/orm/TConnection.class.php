<?php

/**
 * Description of TConnection
 *
 * @author Silvio Pereira
 */
final class TConnection
{

    private function __construct()
    {}

    private static function getCurrentConnection()
    {
        return $_SERVER['conn'];
    }

    private static function setCurrentConnection($conn)
    {
        $_SERVER['conn'] = $conn;
    }

    public static function open($name)
    {
        $conn = self::getCurrentConnection();
        if ($conn == null) {
            
            /*
             * $filename = "app.config/" . $name . ".ini";
             * if (file_exists($filename)) {
             * $db = parse_ini_file($filename);
             * }else {
             * throw new Exception("não existe arquivo '{$filename}");
             * }
             */
            
            $db = ApplicationContext::CONNECTION_PROPERTIES();
            
            $user = $db['user'];
            $pass = $db['pass'];
            $type = $db['type'];
            $host = $db['host'];
            $name = $db['name'];
            
            switch ($type) {
                case 'pgsql':
                    $conn = new PDO("pqsql:dbname={$name};user={$user}; password={$pass}; host={$host}");
                    break;
                case 'mysql':
                    $conn = new PDO("mysql:host={$host};port=3306;dbname={$name}", $user, $pass);
                    break;
                case 'sqlite':
                    $conn = new PDO("sqlite={$name}");
                    break;
                case 'ibase':
                    $conn = new PDO("firebird:dbname={$name}", $user, $pass);
                    break;
                case 'oci8':
                    $conn = new PDO("oci:dbname={$name}", $user, $pass);
                    break;
                case 'mssql':
                    $conn = new PDO("mssql:host={$host}, 1433; dbname={$name}", $user, $pass);
                    break;
                default:
                    throw new Exception("não exist connector para o tipo {$type}");
            }
            
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::setCurrentConnection($conn);
        }
        
        return $conn;
    }
}
?>
