<?php
namespace Controllers;
use Config\Database;
use Models\Room;
use Models\Cours;
use Models\Etudiant;
use Models\User;
use Models\Contact;
use PDO;

class PageController {
    public function homePage(){
        try {
            $database = new Database();
            $pdo = $database->connect();

            $etudiantModel = new Etudiant($pdo);
            $coursModel = new Cours($pdo);
            $roomModel = new Room($pdo);
            $userModel = new User($pdo);

            $etudiants = $etudiantModel->readAll();
            $cours = $coursModel->readAll();
            $rooms = $roomModel->readAll();
            $users = $userModel->readAll();

            try {
                $stmt = $pdo->query("SELECT COUNT(*) FROM contact");
                $contactCount = (int) $stmt->fetchColumn();
            } catch (\PDOException $e) {
                $contactCount = 0;
            }

            $etudiantCount = count($etudiants);
            $coursCount = count($cours);
            $roomCount = count($rooms);
            $userCount = count($users);
        } catch (\Exception $e) {
            $etudiantCount = 0;
            $coursCount = 0;
            $roomCount = 0;
            $userCount = 0;
            $contactCount = 0;
            $cours = [];
            $rooms = [];
        }
        require_once "../views/pages/home.php";
    }
    public function coursPage(){
        // Charger les cours dynamiquement
        try {
            $database = new Database();
            $pdo = $database->connect();
            $coursModel = new Cours($pdo);
            $cours = $coursModel->readAll();
        } catch (\Exception $e) {
            $cours = [];
        }
        require_once "../views/pages/cours.php";
    }
    
    public function roomPage(){
        // Charger les salles dynamiquement
        try {
            $database = new Database();
            $pdo = $database->connect();
            $roomModel = new Room($pdo);
            $rooms = $roomModel->readAll();
        } catch (\Exception $e) {
            $rooms = [];
        }
        require_once "../views/pages/room.php";
    }
    public function etudiantPage(){
        require_once "../views/pages/etudiant.php";
    }
    public function registerPage(){
        require_once "../views/pages/register.php";
    }
    public function loginPage(){
        require_once "../views/pages/login.php";
    }
    public function contactPage(){
        try {
            $database = new Database();
            $pdo = $database->connect();
            $contactModel = new Contact($pdo);
            $contacts = $contactModel->readAll();
        } catch (\Exception $e) {
            $contacts = [];
        }
        require_once "../views/pages/contact.php";
    }
    public function profilPage(){
        require_once "../views/pages/profil.php";
    }
    public function authPage(){
        require_once "../views/pages/user.php";
    }
}