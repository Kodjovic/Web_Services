<?php
session_start();
require 'commun_services.php';

// Cas où l'utilisateur est déjà connecté
if (isset($_SESSION['ident'])) {
    produceError("utilisateur déjà connecté");
    return;
}

// Cas où la requete est mal formulée
if(!isset($_POST['email']) || !isset($_POST['password'])){
    produceErrorPOST();
    return;
}

try {
    $user = new UserEntity();
    $user->setEmail($_POST['email']);
    $user->setPassword($_POST['password']);
    
    $dataAuth = $db->authentifier($user);

    if($dataAuth){
        // Authentification réussie
        $_SESSION['ident']=$dataAuth;
        produceResult(clearData($dataAuth));
    }else{
        // Echec d'authentification
        produceError('email ou password incorrect. Merci de réessayer ');
    }

} catch (Exception $th) {
    produceError($th->getMessage());
}




?>