<?php
require 'commun_services.php';

try {
    $products = $db->getProduct();
    if ($products) {
        produceResult(clearDataArray($products));
    }else{
        produceError('problème de récupération des produit');
    }
} catch (Exception $th) {
    produceError("échec de récupération des produit");
    
}

?>