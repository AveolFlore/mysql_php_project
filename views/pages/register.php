<?php
use Controllers\Auth\AuthController;
$auth = new AuthController();
$msg = $_GET['msg'] ?? null;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Gestion Scolaire</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-box fade-in">

            <h2>Inscription</h2>

            <?php if ($msg): ?>
                <p class="msg"><?= htmlspecialchars($msg) ?></p>
            <?php endif; ?>

            <form action="/auth-store" method="POST">
                <input type="text" name="userName" placeholder="Nom d'utilisateur" required>
                <input type="email" name="email" placeholder="Votre email" required>
                <input type="password" name="mdp" placeholder="Mot de passe" required minlength="6">

                <!-- ✅ Champ ajouté -->
                <input type="password" name="mdp_confirm" placeholder="Confirmer le mot de passe" required minlength="6">

                <input type="submit" value="S'inscrire" name="add_etudiant">
            </form>

            <a href="/page-login">Se connecter</a>

        </div>
    </div>
</body>
</html>