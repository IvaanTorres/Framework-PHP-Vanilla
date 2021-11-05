<?php

namespace core\db;

class Connection{
    static private $instance = null;
    private $pdo;

    function __construct(){
        try {
            $db_type = $_ENV['DB_CONNECTION'];
            $host = $_ENV['DB_HOST'];
            $db_name = $_ENV['DB_DATABASE'];
            $user = $_ENV['DB_USERNAME'];
            $password = $_ENV['DB_PASSWORD'];

            $pdo = new \PDO($db_type . ':host=' . $host . ';dbname=' . $db_name, $user, $password);
            $pdo->exec("set names utf8");
            $pdo->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
            $this->pdo = $pdo;
        } catch (\PDOException $e) {
            echo "Error al conectar con la bbdd<br>";
            echo $e;
        }
    }

    private function get_pdo(){
        return $this->pdo;
    }

    private function get_instance() {
        if(self::$instance == null) {
            self::$instance = new Connection();
        }
        return self::$instance;
    }

    public static function __callStatic($name, $arguments){
        return (new static)->$name(...$arguments);
    }
}
?>