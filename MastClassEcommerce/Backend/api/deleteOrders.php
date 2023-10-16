<?php
require 'commun_services.php';

if (!isset($_REQUEST['idOrder']) || !is_numeric($_REQUEST['id'])) {
    produceErrorRequest();
    return;
}

$order = new ordersEntity();
$order->setIdOrder($_REQUEST['id']);

try {
    $data = $db->deleteOrders($order);
    if ($data) {
        produceResult('Suppression réussi !');
    }else{
        produceError("Erreur de Suppression. Merci de réessayer");
    }

} catch (Exception $th) {
    produceError($th->getMessage());
}



?>