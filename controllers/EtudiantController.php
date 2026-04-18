<?php
namespace Controllers;

// require_once '../models/Etudiant.php';
// require_once '../config/Database.php';
use Config\Database;
use Models\Etudiant;

class EtudiantController {
    private Etudiant $etudiantModel;
    private Database $database;
    private \PDO $pdo;
     public string $nom;
     public string $email;
     public string $age;
     public string $room_id;
     public string $cours_id;
    //  public string $email;

    public function __construct(){
        $this->database = new Database;
        $this->pdo=$this->database->connect();
        $this->etudiantModel = new Etudiant($this->database->connect());
    }
    public function index():array{
        return  $this->etudiantModel->readAll();
    } 
    public function indexJoin():array{
        return  $this->etudiantModel->readJoinAll();
    }
     private function sanitize($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }
      public function initialize(){
        unset($_SESSION["nom"]);
        unset($_SESSION["email"]);
        unset($_SESSION["age"]);
        unset($_SESSION["cours_id"]);
        unset($_SESSION["room_id"]);
        unset($_SESSION["id"]);
      }
    public function store(array $data, $id = null)
    {
        if($_SERVER['REQUEST_METHOD']  === "POST") {
            //Recup assainissement des données
            $validate = [
                'nom' => $this->sanitize($data['nom']),
                'email' => $this->sanitize($data['email']),
                'age' => $this->sanitize($data['age']),
                'cours_id' => (int)$this->sanitize($data['cours_id']),
                'room_id' => (int)$this->sanitize($data['room_id'])
            ];
            //create
            // exit;
            if(!empty($data['nom']) && !empty($data['email']) && !empty($data['age']) && !empty($data['cours_id'])&& !empty($data['room_id'])) {
 
                if( !empty($data['add_etudiant']) && $data['add_etudiant'] == 'Ajouter') {
 
                    $r = $this->etudiantModel->create($validate);
                    header("Location:/page-etudiant?msg=succès");
                   
                    exit;
                }
            }else {
                header("Location: page-etudiant?msg=Tous les champs sont requis");
                exit;
            }
           
        }else {
            header("Location:/page-etudiant?msg=echec");
            exit;
        }
    }
    public function update(array $data, $id = null)
    {
        if($_SERVER['REQUEST_METHOD']  === "POST") {
            //Recup assainissement des données
            $validate = [
                'nom' => $this->sanitize($data['nom']),
                'email' => $this->sanitize($data['email']),
                'age' => $this->sanitize($data['age']),
                'cours_id' => (int)$this->sanitize($data['cours_id']),
                'room_id' => (int)$this->sanitize($data['room_id'])
            ];
            //create
            
            // exit;
            if(!empty($data['nom']) && !empty($data['email']) && !empty($data['age']) && !empty($data['cours_id'])&& !empty($data['room_id'])) {
                if( !empty($data['update_etudiant']) && $data['update_etudiant'] == 'Modifier') {// update
                $id = $data['e_id'];
          
               
                    $r = $this->etudiantModel->update($id, $validate);
                    if($r){
                        $this->initialize();
                        header("Location: page-etudiant?msg=succès");
                        }else {
                        header("Location:/page-etudiant?msg=Erreur");
                    }
               
                }elseif( !empty($data['reset']) && $data['reset'] == 'Annuler') {// update
                        $this->initialize();
                    header("Location: page-etudiant");
                }
                exit;
            }else {
                header("Location: page-etudiant?msg=Tous les champs sont requis");
                exit;
            }
           
        }else {
            header("Location:/page-etudiant?msg=echec");
            exit;
        }
    }

    // public function getById(int $id){
    //  return $this->etudiantModel->getFindId($id);
    // }
    public function destroy(int $id){
     $result= $this->etudiantModel->delete($id);
     if($result){
        header("Location:page-etudiant?msg=succes");
        exit;
     }else {
      header("Location:page-etudiant?msg=echec");
      exit;

     }
    }
    public function edit(int $id){
     $result= $this->etudiantModel->getFindId($id);
     $nom = $result['nom'];
     $email = $result['email'];
     $age = $result['age'];
     $cours_id = $result['cours_id'];
     $room_id = $result['room_id'];
     $id = $result['id'];

     $_SESSION['id']=$id;
     $_SESSION['nom']=$nom;
     $_SESSION['email']=$email;
     $_SESSION['cours_id']=$cours_id;
     $_SESSION['age']=$age;
     $_SESSION['room_id']=$room_id;
      header("Location:page-etudiant");
      exit;
    }
}