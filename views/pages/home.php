<?php
// namespace Middleware;
// use Middleware\Role;
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// sécurité supplémentaire (au cas où)
if (!isset($_SESSION['user'])) {
    header("Location:/page-login");
    exit;
}

$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
   <?php require_once '../views/partials/header.php'; ?>

<div class="container">

    <h1> Bienvenue dans ton Dashboard <?= $_SESSION['user']['userName']?></h1>

    <p>Gère facilement tes étudiants, cours et utilisateurs.</p>

    <div class="cards">

        <div class="card">
            <h3> Étudiants</h3>
            <p>Gestion complète des étudiants</p>
        </div>

        <div class="card">
            <h3>Cours</h3>
            <p>Organisation des cours disponibles</p>
        </div>

        <div class="card">
            <h3> Utilisateurs</h3>
            <p>Gestion des rôles et permissions</p>
        </div>

        <div class="card">
            <h3>Contact</h3>
            <p>Messages des utilisateurs</p>
        </div>

    </div>

</div>
</body>
</html>
