<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Vérification de la session
if (!isset($_SESSION['user'])) {
    header("Location:/page-login");
    exit;
}

$msg = $_GET['msg'] ?? null;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salles</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php require_once '../views/partials/header.php'; ?>

<div class="container">
    <h1>Gestion des Salles</h1>

    <?php if ($msg): ?>
        <p class="msg"><?= htmlspecialchars($msg) ?></p>
    <?php endif; ?>

    <?php 
        // Déterminer si c'est une édition ou une création
        $isEdit = isset($_GET['edit']);
        $roomToEdit = null;
        
        if ($isEdit) {
            $roomId = (int) $_GET['edit'];
            if (!empty($rooms)) {
                foreach ($rooms as $r) {
                    if ($r['id'] === $roomId) {
                        $roomToEdit = $r;
                        break;
                    }
                }
            }
        }
    ?>

    <?php if ($_SESSION['user']['role'] === 'admin'): ?>
    <div class="formulaire">
        <h2><?= $isEdit && $roomToEdit ? 'Modifier la Salle' : 'Ajouter une Salle' ?></h2>
        <form action="<?= $isEdit && $roomToEdit ? '/room-update' : '/room-create' ?>" method="POST">
            <?php if ($isEdit && $roomToEdit): ?>
                <input type="hidden" name="room_id" value="<?= $roomToEdit['id'] ?>">
            <?php endif; ?>

            <label>Nom de la Salle</label>
            <input type="text" name="rooms_name" placeholder="Ex: Salle A101" value="<?= $isEdit && $roomToEdit ? htmlspecialchars($roomToEdit['rooms_name']) : '' ?>" required>

            <button type="submit"><?= $isEdit && $roomToEdit ? 'Mettre à jour' : 'Ajouter' ?></button>

            <?php if ($isEdit && $roomToEdit): ?>
                <a href="/page-room" class="btn-cancel">Annuler</a>
            <?php endif; ?>
        </form>
    </div>
    <?php endif; ?>

    <div class="table">
        <h2>Liste des Salles</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                    <th>Actions</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($rooms)): ?>
                    <?php foreach ($rooms as $room): ?>
                    <tr>
                        <td><?= $room['id'] ?></td>
                        <td><?= htmlspecialchars($room['rooms_name']) ?></td>
                        <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                        <td>
                            <a href="/page-room?edit=<?= $room['id'] ?>" class="btn-edit">Modifier</a>
                            <a href="/room-delete?id=<?= $room['id'] ?>" class="btn-delete">Supprimer</a>
                        </td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">Aucune salle trouvée</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
