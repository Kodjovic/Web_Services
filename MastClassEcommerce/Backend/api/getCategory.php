<?php
require 'commun_services.php';

try {
    $categories = $db->getCategory();
    if ($categories) {
        produceResult(clearDataArray($categories));
    }else{
        produceError('problème de récupération de catégories');
    }
} catch (Exception $th) {
    produceError("échec de récupération des catégories");
    
}

?>