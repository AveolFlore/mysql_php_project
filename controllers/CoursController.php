<?php
namespace Controllers;
// require_once '../models/Cour.php';
// require_once '../config/Database.php';
use Config\Database;
use Models\Cours;

class CoursController{
    private Cours $courModel;
    private Database $database;
    private \PDO $pdo;
    public string $titre;
     public string $description;

     public function __construct(){
        $this->database = new Database;
        $this->pdo=$this->database->connect();
        $this->courModel  = new Cours($this->database->connect());
     }
      public function index():array{
        return  $this->courModel->readAll();
    } 
     public function store(array $data){
        $this->courModel->create($data);
        echo "Nouvel étudiant ajouté avec succès";
    }
    public function getById(int $id){
     return $this->courModel->getFindId($id);
    }
}
