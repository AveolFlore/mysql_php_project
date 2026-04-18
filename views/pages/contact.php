<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    header("Location:/page-login");
    exit;
}

$msg = $_GET['msg'] ?? null;
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <?php require_once '../views/partials/header.php'; ?>

<div class="container">

    <h1>Contactez-nous</h1>

    <?php if ($msg): ?>
        <p class="msg"><?= htmlspecialchars($msg) ?></p>
    <?php endif; ?>

    <div class="contact-box">
        <form action="/contact-create" method="POST">
            <input type="text" name="name" placeholder="Votre nom" value="<?= htmlspecialchars($user['userName']) ?>" readonly required>
            <input type="email" name="email" placeholder="Votre email" value="<?= htmlspecialchars($user['email']) ?>" readonly required>
            <textarea name="message" rows="5" placeholder="Votre message" required></textarea>
            <button type="submit">Envoyer</button>
        </form>
    </div>
    <?php if ($user['role'] === 'admin'): ?>
    <div class="table-container">
        <h2>Messages reçus</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($contacts)): ?>
                    <?php foreach ($contacts as $contact): ?>
                    <tr>
                        <td><?= htmlspecialchars($contact['id']) ?></td>
                        <td><?= htmlspecialchars($contact['name']) ?></td>
                        <td><?= htmlspecialchars($contact['email']) ?></td>
                        <td><?= htmlspecialchars($contact['message']) ?></td>
                        <td><?= htmlspecialchars($contact['created_at'] ?? 'N/A') ?></td>
                        <td>
                            <a href="/contact-delete?id=<?= $contact['id'] ?>" class="btn-delete">Supprimer</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">Aucun contact pour le moment</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>

</div>

</body>
</html>