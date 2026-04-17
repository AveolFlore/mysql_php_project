<?php
require "config/Database.php";
require "models/Etudiant.php";
require "controllers/EtudiantController.php";
require "controllers/CoursController.php";
use Controllers\EtudiantController;
use Controllers\CoursController;
// $con = new Database();
// $rescon=$con->connect();

$etudiant = new EtudiantController();
$cours = new CoursController();
// $data = $etudiant->index();
$data = $cours->index();
// $dataJoin = $etudiant->indexJoin();
// $data = $etudiant->readAll();
print_r($data);
$dataID = $cours->getById(1);
print_r ($dataID);
// foreach($data as $datas){
//     echo 'nom: '. $datas["nom"].' '. 'Age: '. $datas['age'] . "\n";
// }

// $data = [
//     'titre'=> "Python",
//     'description'=> "Langage de programmation",
    
// ];
// $data = $cours->store($data);

?>