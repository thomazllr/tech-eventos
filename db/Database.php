<?php

class Database {
    private static $instance = null;
    private $connection;

    public function __construct($host, $port, $username, $password, $dbname) {
        try {
            $this->connection = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $username, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Falha ao conectar com o banco: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            $config = require __DIR__ . '/db-config.php';
            self::$instance = new self(
                $config['database']['host'],
                $config['database']['port'],
                $config['database']['user'],
                $config['database']['password'],
                $config['database']['dbname']
            );
        }
        return self::$instance;
    }

    public function getConnection(){
         return $this->connection;
    }
}


