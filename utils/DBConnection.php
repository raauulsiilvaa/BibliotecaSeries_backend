<?php
class DBConnection {
    private static $instance = null;
    private $conn;
    private $db_host = 'localhost';
    private $db_user = 'root';
    private $db_password = 'root';
    private $db_db = 'Biblioteca_series';

    private function __construct() {
        $this->conn = @new mysqli(
            $this->db_host,
            $this->db_user,
            $this->db_password,
            $this->db_db
        );

        if ($this->conn->connect_error) {
            die('Error de conexión: ' . $this->conn->connect_error);
        }
    }
    
    public function __destruct() {
        if ($this->conn) {
            $this->conn->close();
        }
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }
}
