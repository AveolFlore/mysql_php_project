<?php
// require_once "../controllers/CoursController.php";
use Controllers\CoursController;
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

    <div class="table">
        <table>
        <thead>
            <tr>
                <th>#id</th>
                <th>Nom COMPLET</th>
                <th>ADRESSE E-MAIL</th>
                <th>DATE D'INSCRIPTION</th>
                <th>ACTION</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($datas as $key => $value):?>
            <tr>
                <td><?php echo htmlspecialchars($value['id']);?></td>
                <td><?php echo htmlspecialchars($value['titre']);?></td>
                <td><?php echo htmlspecialchars($value['description']);?></td>
                <td><?php echo htmlspecialchars($value['created_at']);?></td>
                <td><button class="btn-edit" value="<?php echo htmlspecialchars($value['id']);?>">Modifier</button>
            <button class="btn-delete" value="<?php echo htmlspecialchars($value['id']);?>">Supprimer</button></td>
            </tr>
            <?php endforeach?>
        </tbody>
    </table>
    </div>
</body>
</html>