<?php
namespace Controllers;
class PageController {
    public function homePage(){
        require_once "../views/pages/home.php";
    }
    public function coursPage(){
        require_once "../views/pages/cours.php";
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
        require_once "../views/pages/contact.php";
    }
    public function profilPage(){
        require_once "../views/pages/profil.php";
    }
    public function authPage(){
        require_once "../views/pages/user.php";
    }
}