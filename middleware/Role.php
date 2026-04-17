<?php
namespace Middleware;

class Role{
  public function isAuthenticated(){
    if (!isset($_SESSION['user'])) {
        header('Location: /page-login');
        exit;
    }
}
public function isConnected(){
    if(isset($_SESSION['user'])){
        header('Location: /page-home');
        exit;
    }
}
public function isAdmin(){
    if (!isset($_SESSION['user'])|| $_SESSION['user']['role']!=='admin') {
            echo "Accès refusé";
            exit;
    }
}
}
?>