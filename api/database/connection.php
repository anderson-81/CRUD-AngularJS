<?php

class Connection
{
    private static $instance = null;
    private $conn = null;

    private function __construct()
    {
        try {
            $this->conn = new PDO('mysql:host=127.0.0.1;dbname=estoque', 'root', 'admin');
            //$this->conn = new PDO("sqlite:db.sqlite");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $ex) {
            return NULL;
        }
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new Connection();
        }

        return self::$instance;
    }

    public function getConnection()
    {
        return $this->conn;
    }
}
