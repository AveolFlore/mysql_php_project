<?php
namespace Models;

class Etudiant {
    private \PDO $conn;
    private string $table= "etudiants";
    public int $id;
    public string $nom;
    public string $email;
    public int $age;
    public int $room_id;
    public int $cours_id;

    public function __construct($db){
        $this->conn= $db;
    }
    public function readAll(){
    try {
            $query = "select * from " . $this->table;
            $result = $this->conn->prepare($query);
            $result->execute();
            return $result->fetchAll(\PDO::FETCH_ASSOC);
    } catch (\PDOException $e) {
        echo "erreur :" .$e->getMessage();
    }}
    public function readJoinAll(){
        try {
            $sql= " select etudiants.id,etudiants.nom,etudiants.email,etudiants.age,etudiants.created_at, cours.titre,rooms.rooms_name FROM ". $this->table ." INNER join cours on etudiants.cours_id = cours.id INNER join rooms on etudiants.room_id = rooms.id";
            $stmt=$this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
          echo "erreur :" .$e->getMessage();

        }
    }
    // public function create_dont_us_it(array $data){
    //     try {
    //         $query = "Insert into " . $this->table . "(nom,email,age,cours_id,room_id) values('".$data['nom']."', 
    //                  ' ".$data['email']."', 
    //                   ".$data['age'].", 
    //                   ".$data['cours_id'].", 
    //                   ".$data['room_id'].")";
    //     return$this->conn-> exec($query);
    //     } catch (\PDOException $e) {
    //        echo "erreur :" .$e->getMessage();

    //     }
    // }
    public function create($data){
        $this->nom = $data['nom'];
        $this->email = $data['email'];
        $this->age = $data['age'];
        $this->cours_id = $data['cours_id'];
        $this->room_id = $data['room_id'];
        $sql = "insert into ". $this->table."(nom,email,age,room_id,cours_id) values(:nom,:email,:age,:room_id,:cours_id)";
        $stmt = $this->conn->prepare($sql);

       return $stmt->execute([
            ":nom"=>$this->nom,
            ":email"=>$this->email,
            ":age"=>$this->age,
            ":cours_id"=>$this->cours_id,
            ":room_id"=>$this->room_id
        ]);
    }

    public function  getFindId(int $id){
    try {
        $this->id=$id;

        $sql = "select * from ". $this->table ." where id=?";
        $stmt=$this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);

    } catch (\PDOException $e) {
        echo "erreur :" . $e->getMessage();
    }
    }
       public function  delete(int $id){
    try {
        $this->id=$id;
        $sql = "delete from ". $this->table ." where id=?";
        $stmt=$this->conn->prepare($sql);
       return $stmt->execute([$id]);
        // return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    } catch (\PDOException $e) {
        echo "erreur :" . $e->getMessage();
    }
    }

      public function update(int $id, array $data) {
        try {
                //Affectation des données aux propriétés
                $this->id = $id;
                $this->nom = $data['nom'];
                $this->email = $data['email'];
                $this->age = $data['age'];
                $this->cours_id = $data['cours_id'];
                $this->room_id = $data['room_id'];
 
                $query = "UPDATE " . $this->table . "
                          SET nom = :nom, email = :email, age = :age, cours_id = :cours, room_id = :room_id
                          WHERE id = :id";
       
                $stmt = $this->conn->prepare($query);
       
                return $stmt->execute([
                    ":nom" => $this->nom,
                    ":email" => $this->email,
                    ":age" => $this->age,
                    ":id" => $this->id,
                    ":cours" => $this->cours_id,
                    ":room_id" => $this->room_id
                ]);
            } catch (\PDOException $e) {
                echo "Erreur dans la modification: " . $e->getMessage();
            }
    }
 
 
    

}
?>