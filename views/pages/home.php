<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    header("Location:/page-login");
    exit;
}

$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Gestion Scolaire</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php require_once '../views/partials/header.php'; ?>

    <div class="container">

        <div class="page-header">
            <h1>Dashboard</h1>
            <p class="text-center">Bienvenue, <?= htmlspecialchars($user['userName']) ?> </p>
        </div>

        <div class="dashboard-grid">

            <div class="dashboard-card">
                <h3>Étudiants</h3>
                <div class="count"><?= $etudiantCount ?? 0 ?></div>
                <p>étudiant<?= ($etudiantCount ?? 0) > 1 ? 's' : '' ?> inscrit<?= ($etudiantCount ?? 0) > 1 ? 's' : '' ?></p>
            </div>

            <div class="dashboard-card">
                <h3>Cours</h3>
                <div class="count"><?= $coursCount ?? 0 ?></div>
                <p>cours disponible<?= ($coursCount ?? 0) > 1 ? 's' : '' ?></p>
            </div>

            <div class="dashboard-card">
                <h3>Salles</h3>
                <div class="count"><?= $roomCount ?? 0 ?></div>
                <p>salle<?= ($roomCount ?? 0) > 1 ? 's' : '' ?> disponible<?= ($roomCount ?? 0) > 1 ? 's' : '' ?></p>
            </div>

            <div class="dashboard-card">
                <h3>Utilisateurs</h3>
                <div class="count"><?= $userCount ?? 0 ?></div>
                <p>utilisateur<?= ($userCount ?? 0) > 1 ? 's' : '' ?> actif<?= ($userCount ?? 0) > 1 ? 's' : '' ?></p>
            </div>

            <div class="dashboard-card">
                <h3>Contact</h3>
                <div class="count"><?= $contactCount ?? 0 ?></div>
                <p>message<?= ($contactCount ?? 0) > 1 ? 's' : '' ?> reçu<?= ($contactCount ?? 0) > 1 ? 's' : '' ?></p>
            </div>

        </div>

    </div>

</body>
</html>