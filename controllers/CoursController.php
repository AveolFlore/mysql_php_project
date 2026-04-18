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

    public function sanitize($data){
        return htmlspecialchars(stripslashes(trim($data)));
    }

    public function store(array $data){
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        // Protection admin
        if ($_SESSION['user']['role'] !== 'admin') {
            header("Location:/page-cours?msg=Accès refusé");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== "POST") {
            header("Location:/page-cours?msg=Erreur");
            exit;
        }

        if (empty($data['titre']) || empty($data['description'])) {
            header("Location:/page-cours?msg=Tous les champs sont requis");
            exit;
        }

        $validate = [
            'titre' => $this->sanitize($data['titre']),
            'description' => $this->sanitize($data['description']),
        ];

        $this->courModel->create($validate);
        header("Location:/page-cours?msg=Cours créé avec succès");
        exit;
    }

    public function update(array $data){
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        // Protection admin
        if ($_SESSION['user']['role'] !== 'admin') {
            header("Location:/page-cours?msg=Accès refusé");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== "POST") {
            header("Location:/page-cours?msg=Erreur");
            exit;
        }

        if (empty($data['titre']) || empty($data['description']) || empty($data['cours_id'])) {
            header("Location:/page-cours?msg=Tous les champs sont requis");
            exit;
        }

        $validate = [
            'titre' => $this->sanitize($data['titre']),
            'description' => $this->sanitize($data['description']),
        ];
        $id = (int) $data['cours_id'];
        $result = $this->courModel->update($id, $validate);

        header($result ? "Location:/page-cours?msg=Cours modifié avec succès" : "Location:/page-cours?msg=Erreur");
        exit;
    }

    public function destroy(int $id){
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        // Protection admin
        if ($_SESSION['user']['role'] !== 'admin') {
            header("Location:/page-cours?msg=Accès refusé");
            exit;
        }

        $result = $this->courModel->delete($id);
        header($result ? "Location:/page-cours?msg=Cours supprimé" : "Location:/page-cours?msg=Erreur");
        exit;
    }

    public function getById(int $id){
        return $this->courModel->getFindId($id);
    }
}
