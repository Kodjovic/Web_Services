<?php
require 'commun_services.php';


if (!isset($_REQUEST['id']) || !is_numeric($_REQUEST['id'])) {
    produceErrorRequest();
    return;
}


$user = new UserEntity();
$user->setIdUser($_REQUEST['id']);


try {
    $data = $db->deleteUser($user);

    if ($data) {
        produceResult("Suppression réussie");
    }else{
        produceError("Echec de la supppresion. Merci de réessayer !");
    }


} catch (Exception $th) {


    produceError($th->getMessage());
}
?>
