<?php
// require "../models/Etudiant.php";
// require_once "../controllers/EtudiantController.php";
// require_once "../controllers/CoursController.php";
use Controllers\CoursController;
use Controllers\EtudiantController;

$etudiant = new EtudiantController();
$data = $etudiant->indexJoin();

$cours = new CoursController();
$datas = $cours->index();
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
    <?= require_once '../views/partials/header.php';?>

    <div class="formulaire">
   <form action="<?= isset($_SESSION['id']) ?" /etudiant-update" : "/etudiant-create"?>" method="POST">
    <?php if(!empty($_SESSION['id'])):?>
        <input type="hidden" name="e.id" value="<?=$_SESSION['id'] ??  '' ?>">
        <?php endif?>
         <input type="text" name="nom" placeholder="nom complet" value="<?php echo $_SESSION['nom'] ?? '';?>">
        <input type="email" name="email" placeholder="votre mail" value="<?php echo $_SESSION['email'] ?? '';?>">
        <input type="number" name="age" placeholder="age" value="<?php echo $_SESSION['age'] ?? '';?>">
        <select name="cours_id" id="">
            <option value="cours_id" >Cours</option>
            <?php foreach ($datas as $key => $value):?>
            <option value="<?php echo $value['id'];?>"<?= isset($_SESSION['cours_id']) && (int)$_SESSION['cours_id'] === (int)$value['id'] ? 'selected' : ''?>><?php echo $value['titre'];?></option>
            <?php endforeach?>

        </select>
        <select name="room_id" id="rooms" value="room_id">
            <option value="room_id" >Salles</option>
            <option value="1" <?= isset($_SESSION['room_id']) && (int)$_SESSION['room_id'] === 1? 'selected' : ''?>>RoomA1</option>
            <option value="2" <?= isset($_SESSION['room_id']) && (int)$_SESSION['room_id'] === 2? 'selected' : ''?>>RoomA2</option>
        </select>
        <div>
            <?php if (!empty($_SESSION['id'])): ?>
                <input type="submit" name="update_etudiant" value="Modifier">
                <input type="submit" name="reset" value="Annuler">
                <?php else : ?>
                    <input type="submit" name="add_etudiant" value="Ajouter">
            <?php endif?>

        </div>
   </form>
    </div>
    <div class="table">
        <table>
        <thead>
            <tr>
                <th>#id</th>
                <th>Nom COMPLET</th>
                <th>ADRESSE E-MAIL</th>
                <th>SALLE</th>
                <th>COURS</th>
                <th>DATE D'INSCRIPTION</th>
                <th>ACTION</th>
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
                <td><a href="/etudiant-edit?id=<?php echo $value['id'];?>" class="btn-edit">Modifier</a>
            <a href="/etudiant-delete?id=<?php echo $value['id'];?>" class="btn-delete" value="<?php echo htmlspecialchars($value['id']);?>">Supprimer</a></td>
            </tr>
            <?php endforeach?>
        </tbody>
    </table>
    </div>

</body>
</html>