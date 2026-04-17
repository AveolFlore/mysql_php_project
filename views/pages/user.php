<?php
use Controllers\Auth\AuthController;
$users = new AuthController();
$datas = $users->index();
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
                <th>ROLE</th>
                <th>DATE D'INSCRIPTION</th>
                <th>ACTION</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($datas as $key => $value):?>
            <tr>
                <td><?php echo htmlspecialchars($value['id']);?></td>
                <td><?php echo htmlspecialchars($value['userName']);?></td>
                <td><?php echo htmlspecialchars($value['email']);?></td>
                <td>
<form action="/auth-update" method="POST">
    <input type="hidden" name="e_id" value="<?= $value['id'] ?>">

    <select name="role" onchange="this.form.submit()">
        <option value="user" <?= $value['role'] == 'user' ? 'selected' : '' ?>>User</option>
        <option value="admin" <?= $value['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
        <option value="editor" <?= $value['role'] == 'editor' ? 'selected' : '' ?>>Editor</option>
    </select>
</form>
</td>
                <td><?php echo htmlspecialchars($value['created_at']);?></td>
                <td>
            <a href="/auth-delete?id=<?php echo $value['id'];?>" class="btn-delete" value="<?php echo htmlspecialchars($value['id']);?>">Supprimer</a></td>
            </tr>
            <?php endforeach?>
        </tbody>
    </table>
    </div>
</body>
</html>