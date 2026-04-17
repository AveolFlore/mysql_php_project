<?php
namespace Controllers\Auth;
use Config\Database;
use Models\User;
use Middleware\Role;
use PDO;
class AuthController{
    private User $userModel;
    private Database $database;
    private PDO $pdo;
    public string $userName;
    public string $email;
    public string $mdp;
    // public string $role;

    public function __construct(){
        $this->database = new Database;
        $this->pdo=$this->database->connect();
        $this->userModel = new User($this->database->connect());
    }
    public function index():array{
        return $this->userModel->readAll();
    }
    public function sanitize($data){
        $data = trim($data);
        $data=stripslashes($data);
        $data=htmlspecialchars($data);
        return $data;
    }
    public function initialize(){
        unset($_SESSION["userName"]);
        unset($_SESSION["mdp"]);
        unset($_SESSION["email"]);
        // unset($_SESSION["role"]);
        unset($_SESSION["id"]);
    }

    public function register(array $data){
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $validate = [
                'userName' => $this->sanitize($data["userName"]),
                'email' => $this->sanitize($data["email"]),
                'mdp' => $data["mdp"],
                ];
                
         // Vérifier si email existe déjà
       
        if (!empty($data['userName']) && !empty($data['email'])&& !empty($data['mdp'])) {
             if ($this->userModel->findByEmail($data["email"])) {
                echo "Email déjà utilisé";
                return;
        }
          if(!empty($data['add_etudiant']) && $data['add_etudiant'] == "S'inscrire"){
             $r = $this->userModel->create($validate);
             header("Location:/page-login?msg=succès");      
            exit;       
          }
        }else {
            header("Location:/page-register?msg=Tous les champs sont requis");
            exit;
        }
    }else {
     header("Location:/page-register?msg=echec");
     exit;
    }
    }

    public function login(){
       if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
        if($_SERVER['REQUEST_METHOD']==="POST"){
            $email = $_POST['email'];
            $mdp = $_POST['mdp'];
        $user = $this->userModel->findByEmail($email);
        if (!$user) {
            echo "Utilisateur non trouvé";
            return;
        }
if (password_verify($mdp,$user['mdp'])) {
    $_SESSION['user'] = [
        'id' => $user['id'],
        'userName' => $user['userName'],
        'email' => $user['email'],
        'role' => $user['role'],
    ];
    // echo "connexion reussi";
     header("Location:/page-home");
     exit;
}else{
    echo "Mot de passe incorrect";
}
    }

}
   public function update(array $data, $id = null)
    {
           if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
        if($_SERVER['REQUEST_METHOD']  === "POST") {
            //Recup assainissement des données
            $validate = [
               
                'role' => $this->sanitize($data['role']),
               
            ];
   
            if(!empty($data['role'])) {
                $id = $data['e_id'];
          
               
                    $r = $this->userModel->update($id, $validate);
                    if($r){
                        header("Location: page-auth?msg=succès");
                        }else {
                        header("Location: page-auth?msg=Erreur");
                    }
               
              
                exit;
            }else {
                header("Location: page-etudiant?msg=Tous les champs sont requis");
                exit;
            }
           
        }else {
            header("Location: page-etudiant?msg=echec");
            exit;
        }
    }

    // public function getById(int $id){
    //  return $this->etudiantModel->getFindId($id);
    // }
    public function destroy(int $id){
           if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if($_SESSION['user']['id']===$id){
        header("Location:page-auth");
        exit;
    }
     $result= $this->userModel->delete($id);
     if($result){
        header("Location:page-auth?msg=succes");
        exit;
     }else {
      header("Location:page-auth?msg=echec");
      exit;

     }
    }
    public function edit(int $id){
     $result= $this->userModel->getFindId($id);
   
     $role = $result['role'];
     $id = $result['id'];

     $_SESSION['id']=$id;
     $_SESSION['role']=$role;
    header("Location:page-auth");
      exit;
    }

    public function updateProfile(array $data)
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $id = $data['id'];
    $userName = $this->sanitize($data['userName']);
    $email = $this->sanitize($data['email']);
    $mdp = $data['mdp'] ?? null;

    // récup user actuel
    $user = $this->userModel->findByEmail($_SESSION['user']['email']);

    if (!$user) {
        header("Location: /page-profil?msg=error");
        exit;
    }


    if (!empty($mdp)) {
        $mdp = password_hash($mdp, PASSWORD_DEFAULT);
    } else {
        $mdp = $user['mdp']; // ancien mdp
    }

    $this->userModel->updateProfile($id, [
        'userName' => $userName,
        'email' => $email,
        'mdp' => $mdp
    ]);

    // update session
    $_SESSION['user']['userName'] = $userName;
    $_SESSION['user']['email'] = $email;

    header("Location: /page-profil?msg=success");
    exit;
}

public function logout() {
        session_destroy();
        header("Location:/page-login");
    }

}