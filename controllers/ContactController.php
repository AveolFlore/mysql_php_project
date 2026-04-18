<?php
namespace Controllers;

use Config\Database;
use Models\Contact;
use Models\User;

class ContactController {
    private Contact $contactModel;
    private User $userModel;
    private Database $database;
    private \PDO $pdo;

    public function __construct(){
        $this->database = new Database();
        $this->pdo = $this->database->connect();
        $this->contactModel = new Contact($this->pdo);
        $this->userModel = new User($this->pdo);
    }

    private function sanitize($data){
        return htmlspecialchars(stripslashes(trim($data)));
    }

    public function store(array $data){
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location:/page-contact?msg=Erreur');
            exit;
        }

        $name = $this->sanitize($data['name'] ?? '');
        $email = $this->sanitize($data['email'] ?? '');
        $message = $this->sanitize($data['message'] ?? '');

        if (!$name || !$email || !$message) {
            header('Location:/page-contact?msg=Tous les champs sont requis');
            exit;
        }

        $user = $this->userModel->findByEmail($email);
        if (!$user) {
            header('Location:/page-contact?msg=Email inconnu');
            exit;
        }

        $result = $this->contactModel->create([
            'name' => $name,
            'email' => $email,
            'message' => $message,
        ]);

        header($result ? 'Location:/page-contact?msg=Message envoyé' : 'Location:/page-contact?msg=Erreur');
        exit;
    }

    public function destroy(int $id){
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location:/page-contact?msg=Accès refusé');
            exit;
        }

        $result = $this->contactModel->delete($id);
        header($result ? 'Location:/page-contact?msg=Contact supprimé' : 'Location:/page-contact?msg=Erreur');
        exit;
    }
}
