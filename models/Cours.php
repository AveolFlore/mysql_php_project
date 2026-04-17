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
    $this->titre = $data['description'];
    $sql = "insert into ".$this->table."(titre,description) values(?,?)";
    $stmt = $this->conn->prepare($sql);
   return $stmt->execute([
    "titre"=>$this->titre,
    "description"=>$this->description
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
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    } catch (\PDOException $e) {
        echo "erreur :" . $e->getMessage();
    }
}
}