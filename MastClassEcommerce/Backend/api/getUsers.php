<?php
require 'commun_services.php';

try {
    $users = $db->getUsers();
    if ($users) {
        produceResult(clearDataArray($users));
    }else{
        produceError('Problème de récupération des utilisateurs');
    }
} catch (Exception $th) {
    produceError("Echec de récupération des utilisateurs");
    
}

?>