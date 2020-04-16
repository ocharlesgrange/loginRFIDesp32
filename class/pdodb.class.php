<?php
class Database {
    protected static $db;
    private function __construct() {
        $db_host = "localhost";
        $db_nome = "dbrfid";
        $db_usuario = "root";
        $db_senha = "";
        $db_driver = "mysql";
        $sistema_titulo = "Nome Sistema";
        $sistema_email = "seuemail@gmail.com";
        try {
            self::$db = new PDO("$db_driver:host=$db_host; dbname=$db_nome", $db_usuario, $db_senha);
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$db->exec('SET NAMES utf8');
        }
        catch(PDOException $e) {
            mail($sistema_email, "PDOException em $sistema_titulo", $e->getMessage());
            die("Connection Error: " . $e->getMessage());
        }
    }
    public static function conexao() {
        if (!self::$db) {
            new Database();
        }
        return self::$db;
    }
}
?>