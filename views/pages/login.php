<?php
use Controllers\Auth\AuthController;
$auth = new AuthController();

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
 <div class="auth-container">
    <div class="auth-box fade-in">

        <h2> Connexion</h2>

        <form action="/auth-connect" method="POST">
            <input type="email" name="email" placeholder="Votre email" required>
            <input type="password" name="mdp" placeholder="Mot de passe" required>

            <!-- <button type="submit">Se connecter</button> -->
            <input type="submit" value="Se connecter" name="add_etudiant">

        </form>

        <a href="/page-register">Créer un compte</a>

    </div>
</div>
</body>
</html>