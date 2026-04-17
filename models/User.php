<?php
namespace Models;
use PDO;
class User {
    private PDO $conn; 
    private string $table = "users";
    public int $id;
    public string $userName; 
    public string $email;
    public string $mdp;
    public string $string;

    public function __construct($db){
        $this->conn=$db;
    }
    public function readAll(){
        try {
            $query = "select * from ". $this->table ;
            $result = $this->conn->prepare($query);
            $result->execute();
            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
           echo "erreur :" .$e->getMessage();
        }
    }

     public function findByEmail($email) {
        $query = "SELECT * FROM $this->table WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
      public function create($data){
        $this->userName = $data['userName'];
        $this->email = $data['email'];
        // $this->role = $data['role'];
        $this->mdp = $data['mdp'];
        $sql = "insert into ". $this->table."(userName,email,mdp) values(:userName,:email,:mdp)";
        $stmt = $this->conn->prepare($sql);
        //hashage du mot de passe
        $hashedPassword = password_hash($this->mdp, PASSWORD_DEFAULT);
       return $stmt->execute([
            ":userName"=>$this->userName,
            ":email"=>$this->email,
            ":mdp"=>$hashedPassword,
            // ":role"=>$this->role
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
            
                $this->role = $data['role'];
                $query = "UPDATE " . $this->table . "
                          SET role = :role 
                          WHERE id = :id";
       
                $stmt = $this->conn->prepare($query);
       
                return $stmt->execute([
                    ":role" => $this->role,
                    ":id" => $this->id,
                  
                ]);
            } catch (\PDOException $e) {
                echo "Erreur dans la modification: " . $e->getMessage();
            }
    }

    public function updateProfile($id, $data)
{
    $query = "UPDATE users 
              SET userName = :userName,
                  email = :email,
                  mdp = :mdp
              WHERE id = :id";

    $stmt = $this->conn->prepare($query);

    return $stmt->execute([
        ':userName' => $data['userName'],
        ':email' => $data['email'],
        ':mdp' => $data['mdp'],
        ':id' => $id
    ]);
}
}