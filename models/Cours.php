<?php 
namespace Models;

class Cours {

private \PDO $conn;
private string $table = "cours";
public int $id;
public string $titre;
public string $description;

public function __construct($db){
    $this->conn = $db;
}
public function readAll(){
    try {
        $sql="select * from ".$this->table;
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    } catch (\PDOException $e) {
        echo "error : ".$e->getMessage();
    }
}

public function create($data){
try {
        $this->titre = $data['titre'];
        $this->description = $data['description'];
        $sql = "insert into ".$this->table."(titre,description) values(?,?)";
        $stmt = $this->conn->prepare($sql);
       return $stmt->execute([
        $this->titre,
        $this->description
       ]);
} catch (\PDOException $e) {
        echo "error : ".$e->getMessage();
}
}

public function getFindId(int $id){
     try {
        $sql = "select * from ". $this->table ." where id=?";
        $stmt=$this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);

    } catch (\PDOException $e) {
        echo "erreur :" . $e->getMessage();
    }
}

public function update(int $id, array $data){
    try {
        $this->id = $id;
        $sql = "UPDATE " . $this->table . " SET titre = :titre, description = :description WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ":titre" => $data['titre'],
            ":description" => $data['description'],
            ":id" => $this->id
        ]);
    } catch (\PDOException $e) {
        echo "Erreur dans la modification: " . $e->getMessage();
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