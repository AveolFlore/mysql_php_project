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
    <title>Cours</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php require_once '../views/partials/header.php'; ?>

    <div class="container">
        <h1>Gestion des Cours</h1>

        <?php if ($msg): ?>
            <p class="msg"><?= htmlspecialchars($msg) ?></p>
        <?php endif; ?>

        <?php 
            // Déterminer si c'est une édition ou une création
            $isEdit = isset($_GET['edit']);
            $courseToEdit = null;
            
            if ($isEdit) {
                $courseId = (int) $_GET['edit'];
                if (!empty($cours)) {
                    foreach ($cours as $c) {
                        if ($c['id'] === $courseId) {
                            $courseToEdit = $c;
                            break;
                        }
                    }
                }
            }
        ?>

        <?php if ($_SESSION['user']['role'] === 'admin'): ?>
        <div class="formulaire">
            <h2><?= $isEdit && $courseToEdit ? 'Modifier le Cours' : 'Ajouter un Cours' ?></h2>
            <form action="<?= $isEdit && $courseToEdit ? '/cours-update' : '/cours-create' ?>" method="POST">
                <?php if ($isEdit && $courseToEdit): ?>
                    <input type="hidden" name="cours_id" value="<?= $courseToEdit['id'] ?>">
                <?php endif; ?>

                <label>Titre du Cours</label>
                <input type="text" name="titre" placeholder="Ex: Mathématiques" value="<?= $isEdit && $courseToEdit ? htmlspecialchars($courseToEdit['titre']) : '' ?>" required>

                <label>Description</label>
                <textarea name="description" placeholder="Description du cours" required><?= $isEdit && $courseToEdit ? htmlspecialchars($courseToEdit['description']) : '' ?></textarea>

                <button type="submit"><?= $isEdit && $courseToEdit ? 'Mettre à jour' : 'Ajouter' ?></button>

                <?php if ($isEdit && $courseToEdit): ?>
                    <a href="/page-cours" class="btn-cancel">Annuler</a>
                <?php endif; ?>
            </form>
        </div>
        <?php endif; ?>

        <div class="table">
            <h2>Liste des Cours</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Titre</th>
                        <th>Description</th>
                        <th>Date de création</th>
                        <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                        <th>Actions</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($cours)): ?>
                        <?php foreach ($cours as $course): ?>
                        <tr>
                            <td><?= $course['id'] ?></td>
                            <td><?= htmlspecialchars($course['titre']) ?></td>
                            <td><?= htmlspecialchars($course['description']) ?></td>
                            <td><?= htmlspecialchars($course['created_at'] ?? 'N/A') ?></td>
                            <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                            <td>
                                <a href="/page-cours?edit=<?= $course['id'] ?>" class="btn-edit">Modifier</a>
                                <a href="/cours-delete?id=<?= $course['id'] ?>" class="btn-delete">Supprimer</a>
                            </td>
                            <?php endif; ?>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">Aucun cours trouvé</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>