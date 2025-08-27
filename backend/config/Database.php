<?php
    namespace Backend\config;

    class Database {
        private $host="localhost:8889";
        private $db_name="ecm-php";
        private $username="root";
        private $password="root";
        public $conn;

        public function connect() {
            $this->conn = null;

            try{
              $this->conn = new \PDO("mysql:host={$this->host};dbname={$this->db_name}", $this->username, $this->password);
              $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            } catch (\PDOException $ex) {
              echo "Error de conexion: " . $ex->getMessage();
            }
            return $this->conn;
        }
    }
?>