<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user'])) {
    header("Location:/page-login");
    exit;
}

$user = $_SESSION['user'];
$edit = isset($_GET['edit']);
$editMdp = isset($_GET['edit-mdp']); 

$msg = $_GET['msg'] ?? null;
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

    <h1 class="profile-title">Mon Profil</h1>

    <?php if ($msg): ?>
        <p class="msg"><?= htmlspecialchars($msg) ?></p>
    <?php endif; ?>

    <div class="profile-grid">

        <div class="profile-card">
            <p><strong>ID :</strong> <?= $user['id'] ?></p>
            <p><strong>Nom :</strong> <?= htmlspecialchars($user['userName']) ?></p>
            <p><strong>Email :</strong> <?= htmlspecialchars($user['email']) ?></p>
            <p><strong>Rôle :</strong> <?= htmlspecialchars($user['role']) ?></p>

            <?php if (!$edit && !$editMdp): ?>
                <a href="/page-profil?edit=true" class="btn-edit"> Modifier le profil</a>
                <a href="/page-profil?edit-mdp=true" class="btn-edit"> Changer le mot de passe</a>
            <?php endif; ?>
        </div>

        <?php if ($edit): ?>
        <div class="profile-form">
            <h2>Modifier le profil</h2>
            <form action="/auth-update-profile" method="POST">
                <input type="hidden" name="id" value="<?= $user['id'] ?>">

                <label>Nom</label>
                <input type="text" name="userName" value="<?= htmlspecialchars($user['userName']) ?>" required>

                <label>Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

                <button type="submit">Enregistrer</button>
            </form>
            <a href="/page-profil">Annuler</a>
        </div>
        <?php endif; ?>

        <?php if ($editMdp): ?>
        <div class="profile-form">
            <h2>Changer le mot de passe</h2>
            <form action="/auth-update-password" method="POST">
                <input type="hidden" name="id" value="<?= $user['id'] ?>">

                <label>Ancien mot de passe</label>
                <input type="password" name="ancien_mdp" required>

                <label>Nouveau mot de passe</label>
                <input type="password" name="nouveau_mdp" required minlength="6">

                <label>Confirmer le nouveau mot de passe</label>
                <input type="password" name="confirmation" required minlength="6">

                <button type="submit">Mettre à jour</button>
            </form>
            <a href="/page-profil">Annuler</a>
        </div>
        <?php endif; ?>

    </div>
</div>

</body>
</html>