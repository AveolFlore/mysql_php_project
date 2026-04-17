<?php 
namespace Config;
class Database {
    private $host ="127.0.0.1";
    private $db_name = "gestion_ecole";
    private $username = "root";
    private $password = "";
    public $conn;
    public function connect():\PDO{
        $this->conn = null;
        try {
            $this->conn = new \PDO("mysql:host=" . $this->host ."; dbname=". $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            // echo "connexion pdo Ok";
        } catch (\PDOException $e) {
          echo "Erreur connexion : " . $e->getMessage();
        }
        return $this->conn;
}
}
?>