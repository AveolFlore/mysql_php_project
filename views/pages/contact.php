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

    <h1>Contactez-nous</h1>

    <div class="contact-box">

        <form action="/send-message" method="POST">

            <input type="text" name="name" placeholder="Votre nom">

            <input type="email" name="email" placeholder="Votre email">

            <textarea name="message" rows="5" placeholder="Votre message"></textarea>

            <button type="submit">Envoyer</button>

        </form>

    </div>

</div>

</body>
</html>