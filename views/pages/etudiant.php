<?php
// require "../models/Etudiant.php";
// require_once "../controllers/EtudiantController.php";
// require_once "../controllers/CoursController.php";
use Controllers\CoursController;
use Controllers\EtudiantController;
use Controllers\RoomController;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Vérification de la session
if (!isset($_SESSION['user'])) {
    header("Location:/page-login");
    exit;
}

$msg = $_GET['msg'] ?? null;

$etudiant = new EtudiantController();
$data = $etudiant->indexJoin();

$cours = new CoursController();
$datas = $cours->index();

$roomController = new RoomController();
$rooms = $roomController->index();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Étudiants</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?= require_once '../views/partials/header.php';?>

    <div class="container">
        <h1>Gestion des Étudiants</h1>

        <?php if ($msg): ?>
            <p class="msg"><?= htmlspecialchars($msg) ?></p>
        <?php endif; ?>

        <div class="formulaire">
            <h2><?= isset($_SESSION['id']) ? 'Modifier' : 'Ajouter' ?> un Étudiant</h2>
            <form action="<?= isset($_SESSION['id']) ? "/etudiant-update" : "/etudiant-create"?>" method="POST">
                <?php if(!empty($_SESSION['id'])):?>
                    <input type="hidden" name="e.id" value="<?=$_SESSION['id'] ?? '' ?>">
                <?php endif?>

                <label for="nom">Nom complet</label>
                <input type="text" id="nom" name="nom" placeholder="Nom complet" value="<?php echo $_SESSION['nom'] ?? '';?>" required>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="votre.email@example.com" value="<?php echo $_SESSION['email'] ?? '';?>" required>

                <label for="age">Âge</label>
                <input type="number" id="age" name="age" placeholder="18" value="<?php echo $_SESSION['age'] ?? '';?>" required>

                <label for="cours_id">Cours</label>
                <select name="cours_id" id="cours_id" required>
                    <option value="">Sélectionner un cours</option>
                    <?php foreach ($datas as $key => $value):?>
                    <option value="<?php echo $value['id'];?>"<?= isset($_SESSION['cours_id']) && (int)$_SESSION['cours_id'] === (int)$value['id'] ? 'selected' : ''?>><?php echo $value['titre'];?></option>
                    <?php endforeach?>
                </select>

                <label for="room_id">Salle</label>
                <select name="room_id" id="room_id" required>
                    <option value="">Sélectionner une salle</option>
                    <?php foreach ($rooms as $value): ?>
            <option value="<?= $value['id'] ?>" <?= isset($_SESSION['room_id']) && (int)$_SESSION['room_id'] === (int)$value['id'] ? 'selected' : '' ?>><?= htmlspecialchars($value['rooms_name']) ?></option>
        <?php endforeach; ?>
                </select>

                <?php if (!empty($_SESSION['id'])): ?>
                    <input type="submit" name="update_etudiant" value="Modifier">
                    <a href="/etudiant-create">Annuler</a>
                <?php else: ?>
                    <input type="submit" name="add_etudiant" value="Ajouter">
                <?php endif; ?>
            </form>
        </div>

        <div class="table">
            <h2>Liste des Étudiants</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom complet</th>
                        <th>Email</th>
                        <th>Salle</th>
                        <th>Cours</th>
                        <th>Date d'inscription</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $key => $value):?>
                    <tr>
                        <td><?php echo htmlspecialchars($value['id']);?></td>
                        <td><?php echo htmlspecialchars($value['nom']);?></td>
                        <td><?php echo htmlspecialchars($value['email']);?></td>
                        <td><?php echo htmlspecialchars($value['rooms_name']);?></td>
                        <td><?php echo htmlspecialchars($value['titre']);?></td>
                        <td><?php echo htmlspecialchars($value['created_at']);?></td>
                        <td>
                            <a href="/etudiant-edit?id=<?php echo $value['id'];?>" class="btn-edit">Modifier</a>
                            <a href="/etudiant-delete?id=<?php echo $value['id'];?>" class="btn-delete">Supprimer</a>
                        </td>
                    </tr>
                    <?php endforeach?>
                </tbody>
            </table>
        </div>

</body>
</html>