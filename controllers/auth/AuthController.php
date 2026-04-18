<?php
namespace Controllers\Auth;
use Config\Database;
use Models\User;
use PDO;

class AuthController {
    private User $userModel;
    private Database $database;
    private PDO $pdo;

    public function __construct(){
        $this->database  = new Database;
        $this->pdo       = $this->database->connect();
        $this->userModel = new User($this->pdo); 
    }

    public function index(): array {
        return $this->userModel->readAll();
    }

    public function sanitize($data){
        return htmlspecialchars(stripslashes(trim($data)));
    }

   public function register(array $data){
    if ($_SERVER['REQUEST_METHOD'] !== "POST") {
        header("Location:/page-register?msg=echec");
        exit;
    }

    if (empty($data['userName']) || empty($data['email']) || empty($data['mdp']) || empty($data['mdp_confirm'])) {
        header("Location:/page-register?msg=Tous les champs sont requis");
        exit;
    }

    // ✅ Vérification de la confirmation
    if ($data['mdp'] !== $data['mdp_confirm']) {
        header("Location:/page-register?msg=Les mots de passe ne correspondent pas");
        exit;
    }

    // ✅ Longueur minimale
    if (strlen($data['mdp']) < 6) {
        header("Location:/page-register?msg=Mot de passe trop court (6 caractères minimum)");
        exit;
    }

    $validate = [
        'userName' => $this->sanitize($data['userName']),
        'email'    => $this->sanitize($data['email']),
        'mdp'      => $data['mdp'],
    ];

    if ($this->userModel->findByEmail($validate['email'])) {
        header("Location:/page-register?msg=Email déjà utilisé");
        exit;
    }

    $this->userModel->create($validate);
    header("Location:/page-login?msg=Compte créé avec succès");
    exit;
}
    public function login(){
        if (session_status() === PHP_SESSION_NONE) session_start();

        if ($_SERVER['REQUEST_METHOD'] !== "POST") {
            header("Location:/page-login");
            exit;
        }

        $email = $_POST['email'] ?? '';
        $mdp   = $_POST['mdp'] ?? '';
        $user  = $this->userModel->findByEmail($email);

        if (!$user) {
            header("Location:/page-login?msg=Utilisateur non trouvé");
            exit;
        }

        if (password_verify($mdp, $user['mdp'])) {
            $_SESSION['user'] = [
                'id'       => $user['id'],
                'userName' => $user['userName'],
                'email'    => $user['email'],
                'role'     => $user['role'],
            ];
            header("Location:/page-home");
            exit;
        }

        header("Location:/page-login?msg=Mot de passe incorrect");
        exit;
    }

    public function update(array $data){
        if (session_status() === PHP_SESSION_NONE) session_start();

        if ($_SERVER['REQUEST_METHOD'] !== "POST") {
            header("Location: page-auth?msg=echec");
            exit;
        }

        if (empty($data['role']) || empty($data['e_id'])) {
            header("Location: page-auth?msg=Tous les champs sont requis");
            exit;
        }

        $validate = ['role' => $this->sanitize($data['role'])];
        $id = (int) $data['e_id'];
        $r  = $this->userModel->update($id, $validate);

        header($r ? "Location: page-auth?msg=succès" : "Location: page-auth?msg=Erreur");
        exit;
    }

    public function destroy(int $id){
        if (session_status() === PHP_SESSION_NONE) session_start();

        if ($_SESSION['user']['id'] === $id) {
            header("Location:page-auth?msg=Impossible de supprimer votre propre compte");
            exit;
        }

        $result = $this->userModel->delete($id);
        header($result ? "Location:page-auth?msg=succes" : "Location:page-auth?msg=echec");
        exit;
    }

    public function edit(int $id){
        $result = $this->userModel->getFindId($id);
        $_SESSION['id']   = $result['id'];
        $_SESSION['role'] = $result['role'];
        header("Location:page-auth");
        exit;
    }

    public function updateProfile(array $data){
        if (session_status() === PHP_SESSION_NONE) session_start();

        $id       = (int) $data['id'];
        // Vérifier que l'utilisateur ne modifie que son propre profil
        if ($id !== $_SESSION['user']['id']) {
            header("Location:/page-profil?msg=Accès refusé");
            exit;
        }
        
        $userName = $this->sanitize($data['userName']);
        $email    = $this->sanitize($data['email']);

        // Vérifier que l'utilisateur existe
        $user = $this->userModel->getFindId($id);
        if (!$user) {
            header("Location:/page-profil?msg=error");
            exit;
        }

        $r = $this->userModel->updateProfile($id, [
            'userName' => $userName,
            'email'    => $email,
        ]);

        if ($r) {
            $_SESSION['user']['userName'] = $userName;
            $_SESSION['user']['email']    = $email;
            header("Location:/page-profil?msg=success");
        } else {
            header("Location:/page-profil?msg=error");
        }
        exit;
    }

    public function updatePassword(array $data){
        if (session_status() === PHP_SESSION_NONE) session_start();

        $id          = (int) $data['id'];
        // Vérifier que l'utilisateur ne modifie que son propre mot de passe
        if ($id !== $_SESSION['user']['id']) {
            header("Location:/page-profil?msg=Accès refusé");
            exit;
        }
        
        $ancienMdp   = $data['ancien_mdp'] ?? '';
        $nouveauMdp  = $data['nouveau_mdp'] ?? '';
        $confirmation = $data['confirmation'] ?? '';

        $user = $this->userModel->getFindId($id);
        if (!$user) {
            header("Location:/page-profil?msg=error");
            exit;
        }

        if (!password_verify($ancienMdp, $user['mdp'])) {
            header("Location:/page-profil?msg=Ancien mot de passe incorrect");
            exit;
        }

        if ($nouveauMdp !== $confirmation) {
            header("Location:/page-profil?msg=Les mots de passe ne correspondent pas");
            exit;
        }

        if (strlen($nouveauMdp) < 6) {
            header("Location:/page-profil?msg=Mot de passe trop court");
            exit;
        }

        $hashed = password_hash($nouveauMdp, PASSWORD_DEFAULT);
        $r = $this->userModel->updatePassword($id, $hashed);

        header($r ? "Location:/page-profil?msg=Mot de passe mis à jour" : "Location:/page-profil?msg=error");
        exit;
    }

    public function logout(){
        if (session_status() === PHP_SESSION_NONE) session_start();
        session_destroy();
        header("Location:/page-login");
        exit;
    }
}