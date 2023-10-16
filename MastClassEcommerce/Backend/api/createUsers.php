<?php
require 'commun_services.php';


if (!isset($_POST['sexe']) || !isset($_POST['pseudo']) || !isset($_POST['firstname']) ||
!isset($_POST['lastname']) || !isset($_POST['password']) || !isset($_POST['email']) || !isset($_POST['dateBirth'])) {
    produceErrorPOST();
    return;
}

if (empty($_POST['sexe']) || empty($_POST['pseudo']) || empty($_POST['firstname']) ||
empty($_POST['lastname']) || empty($_POST['password']) || empty($_POST['email']) || empty($_POST['dateBirth'])) {
    produceErrorPOST();
    return;
}

$user = new UserEntity();
$user->setSexe($_POST['sexe']);
$user->setPseudo($_POST['pseudo']);
$user->setFirstname($_POST['firstname']);
$user->setLastname($_POST['lastname']);
$user->setEmail($_POST['email']);
$user->setPassword($_POST['password']);
$user->setDateBirth($_POST['dateBirth']);

try {
    var_dump($user);
    $data = $db->createUser($user);
    if ($data) {
        produceResult("Compte utilisateur crée avec succès");
    }else{
        produceError("problème rencontré lors de la création du compte");
    }


} catch (Exception $th) {


    produceError($th->getMessage());
}
?>
