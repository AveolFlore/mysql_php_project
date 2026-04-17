<?php
session_start();
use Controllers\PageController;
use Controllers\CoursController;
use Controllers\EtudiantController;
use Controllers\Auth\AuthController;
use Middleware\Role;
$middleware = new Role();
$route = $_SERVER['REQUEST_URI'];
$route = explode('?',$route)[0];

if (strlen($route)>1) {
    $route = substr($route,1);
}

$part = explode('-',$route);
$controllerName = $part[0] ?? '/';
$action = $part[1] ?? 'home';
$id = $_GET['id'] ?? null;

//Protections

$protectedPages = ['home','etudiant','cours','contact','profil','user'];
if (in_array($action,$protectedPages)) {
    $middleware->isAuthenticated();
}

if(in_array($action,['login','register'])){
    $middleware -> isConnected();
}

if (in_array($action,['delete','update'])) {
    $middleware->isAdmin();
}

if (isset($controllerName)) {
    try {
        switch ($controllerName) {
            case '/':
               $controllerInstance = new PageController();
                break;
            case 'page':
                $controllerInstance = new PageController();
                break;
            case 'etudiant':
               $controllerInstance = new EtudiantController();
                break;
            // case 'register':
            //    $controllerInstance = new AuthController();
            //     break;
            // case 'login':
            //    $controllerInstance = new AuthController();
            //     break;
            case 'auth':
               $controllerInstance = new AuthController();
                break;
            default:
                echo "Controller non existant !";
                break;
        }
    } catch (Exception $e) {
        echo "erreur : ". $e->getMessage();
    }
}
if (isset($action)) {
        switch ($action) {
            case 'home':
               $controllerInstance->homePage();
                break;
            case 'auth':
               $controllerInstance->authPage();
                break;
            case 'profil':
               $controllerInstance->profilPage();
                break;
            case 'register':
               $controllerInstance->registerPage();
                break;
            case 'login':
               $controllerInstance->loginPage();
                break;
            case 'etudiant':
               $controllerInstance->etudiantPage();
                break;
            case 'cours':
               $controllerInstance->coursPage();
                break;
            case 'contact':
                $controllerInstance->contactPage();
                break;
            case 'create':
               $controllerInstance->store($_POST);
                break;
            case 'store':
               $controllerInstance->register($_POST);
                break;
            case 'logout':
                $controllerInstance->logout();
                break;
            case 'connect':
               $controllerInstance->login();
                break;
            case 'edit':
               $controllerInstance->edit($id);
                break;
            case 'update':
               $controllerInstance->update($_POST);
                break;
            case 'delete':
               $controllerInstance->destroy($id);
                break;
            case 'user':
               $controllerInstance->index();
                break;
            case 'update-profile':
                $controllerInstance->updateProfile($_POST);
                break;
            default:
                echo "Action non existant !";
                break;
        }
} 





