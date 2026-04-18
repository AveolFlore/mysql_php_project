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
    <title>Connexion - Gestion Scolaire</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-box">
            <h2>Connexion</h2>

            <?php if ($msg): ?>
                <p class="msg"><?= htmlspecialchars($msg) ?></p>
            <?php endif; ?>

            <form action="/auth-connect" method="POST">
                <input type="email" name="email" placeholder="Votre email" required>
                <input type="password" name="mdp" placeholder="Mot de passe" required>
                <button type="submit">Se connecter</button>
            </form>

            <a href="/page-register">Créer un compte</a>
        </div>
    </div>
</body>
</html>