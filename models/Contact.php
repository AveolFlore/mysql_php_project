<?php
namespace Models;

class Contact {
    private \PDO $conn;
    private string $table = "contacts";

    public int $id;
    public string $name;
    public string $email;
    public string $message;

    public function __construct($db){
        $this->conn = $db;
    }

    public function readAll(){
        try {
            $query = "SELECT * FROM " . $this->table . " ORDER BY created_at DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "erreur : " . $e->getMessage();
        }
    }

    public function create(array $data){
        try {
            $this->name = $data['name'];
            $this->email = $data['email'];
            $this->message = $data['message'];

            $sql = "INSERT INTO " . $this->table . " (name, email, message) VALUES (:name, :email, :message)";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                ':name' => $this->name,
                ':email' => $this->email,
                ':message' => $this->message,
            ]);
        } catch (\PDOException $e) {
            echo "erreur : " . $e->getMessage();
        }
    }

    public function delete(int $id){
        try {
            $this->id = $id;
            $sql = "DELETE FROM " . $this->table . " WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([$this->id]);
        } catch (\PDOException $e) {
            echo "erreur : " . $e->getMessage();
        }
    }
}
