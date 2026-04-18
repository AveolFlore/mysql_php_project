<?php
namespace Models;
use PDO;

class Room {
    private PDO $conn; 
    private string $table = "rooms";
    public int $id;
    public string $rooms_name;

    public function __construct($db){
        $this->conn = $db;
    }

    public function readAll(){
        try {
            $query = "SELECT * FROM " . $this->table;
            $result = $this->conn->prepare($query);
            $result->execute();
            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Erreur: " . $e->getMessage();
        }
    }

    public function getFindId(int $id){
        try {
            $this->id = $id;
            $sql = "SELECT * FROM " . $this->table . " WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Erreur: " . $e->getMessage();
        }
    }

    public function create($data){
        try {
            $this->rooms_name = $data['rooms_name'];
            $sql = "INSERT INTO " . $this->table . " (rooms_name) VALUES (:rooms_name)";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([":rooms_name" => $this->rooms_name]);
        } catch (\PDOException $e) {
            echo "Erreur: " . $e->getMessage();
        }
    }

    public function update(int $id, array $data){
        try {
            $this->id = $id;
            $this->rooms_name = $data['rooms_name'];
            $sql = "UPDATE " . $this->table . " SET rooms_name = :rooms_name WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                ":rooms_name" => $this->rooms_name,
                ":id" => $this->id
            ]);
        } catch (\PDOException $e) {
            echo "Erreur: " . $e->getMessage();
        }
    }

    public function delete(int $id){
        try {
            $this->id = $id;
            $sql = "DELETE FROM " . $this->table . " WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([$id]);
        } catch (\PDOException $e) {
            echo "Erreur: " . $e->getMessage();
        }
    }
}
