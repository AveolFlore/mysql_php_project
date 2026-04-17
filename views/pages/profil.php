<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    header("Location:/page-login");
    exit;
}
$edit = isset($_GET['edit']);
$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Profil</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php require_once '../views/partials/header.php'; ?>

<div class="profile-container">

    <h1 class="profile-title"> Mon Profil</h1>

    <?php if(!$edit): ?>
        <a href="/page-profil?edit=true" class="btn-edit"> Modifier</a>
    <?php endif; ?>

    <div class="profile-grid">


        <?php if($edit): ?>
        <div class="profile-form">

            <form action="/auth-update-profile" method="POST">

                <input type="hidden" name="id" value="<?= $user['id'] ?>">

                <label>Nom</label>
                <input type="text" name="userName"
                    value="<?= htmlspecialchars($user['userName']) ?>">

                <label>Email</label>
                <input type="email" name="email"
                    value="<?= htmlspecialchars($user['email']) ?>">

                <label>Nouveau mot de passe</label>
                <input type="password" name="mdp"
                    placeholder="Laisser vide si inchangé">

                <button type="submit"> Enregistrer</button>
            </form>

            <a href="/page-profil"> Annuler</a>

        </div>
        <?php endif; ?>

 
        <div class="profile-card">
            <p><strong>ID :</strong> <?= $user['id'] ?></p>
            <p><strong>Nom :</strong> <?= $user['userName'] ?></p>
            <p><strong>Email :</strong> <?= $user['email'] ?></p>
            <p><strong>Rôle :</strong> <?= $user['role'] ?></p>
        </div>

    </div>

</div>

</body>
</html>