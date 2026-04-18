<?php
namespace Controllers;

use Config\Database;
use Models\Room;
use PDO;

class RoomController {
    private Room $roomModel;
    private Database $database;
    private PDO $pdo;

    public function __construct(){
        $this->database = new Database();
        $this->pdo = $this->database->connect();
        $this->roomModel = new Room($this->pdo);
    }

    public function index(){
        return $this->roomModel->readAll();
    }

    public function sanitize($data){
        return htmlspecialchars(stripslashes(trim($data)));
    }

    public function roomPage(){
        $rooms = $this->index();
        include '../views/pages/room.php';
    }

    public function store(array $data){
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        // Protection admin
        if ($_SESSION['user']['role'] !== 'admin') {
            header("Location:/page-room?msg=Accès refusé");
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== "POST") {
            header("Location:/page-room?msg=Erreur");
            exit;
        }

        if (empty($data['rooms_name'])) {
            header("Location:/page-room?msg=Le nom de la salle est requis");
            exit;
        }

        $validate = [
            'rooms_name' => $this->sanitize($data['rooms_name']),
        ];

        $this->roomModel->create($validate);
        header("Location:/page-room?msg=Salle créée avec succès");
        exit;
    }

    public function update(array $data){
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        // Protection admin
        if ($_SESSION['user']['role'] !== 'admin') {
            header("Location:/page-room?msg=Accès refusé");
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== "POST") {
            header("Location:/page-room?msg=Erreur");
            exit;
        }

        if (empty($data['rooms_name']) || empty($data['room_id'])) {
            header("Location:/page-room?msg=Tous les champs sont requis");
            exit;
        }

        $validate = ['rooms_name' => $this->sanitize($data['rooms_name'])];
        $id = (int) $data['room_id'];
        $result = $this->roomModel->update($id, $validate);

        header($result ? "Location:/page-room?msg=Salle modifiée avec succès" : "Location:/page-room?msg=Erreur");
        exit;
    }

    public function destroy(int $id){
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        // Protection admin
        if ($_SESSION['user']['role'] !== 'admin') {
            header("Location:/page-room?msg=Accès refusé");
            exit;
        }
        
        $result = $this->roomModel->delete($id);
        header($result ? "Location:/page-room?msg=Salle supprimée" : "Location:/page-room?msg=Erreur");
        exit;
    }
}
