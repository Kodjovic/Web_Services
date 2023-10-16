<?php
require 'commun_services.php';

try {
    $orders = $db->getOrders();
    if ($orders) {
        produceResult(clearDataArray($orders));
    }else{
        produceError('problème de récupération des commandes');
    }
} catch (Exception $th) {
    produceError("échec de récupération des commandes");
    
}

?>