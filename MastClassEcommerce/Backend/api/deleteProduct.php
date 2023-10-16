<?php
require 'commun_services.php';


if (!isset($_REQUEST['id']) || !is_numeric($_REQUEST["id"])) {
    produceErrorRequest();
    return;
}



$product = new ProductEntity();
$product->setIdProduct($_REQUEST['id']);



try {
    $data = $db->deleteProduct($product);
    if ($data) {
        produceResult("Suppresssion succès");
    }else{
        produceError("Echec de la suppression. Merci de réessayer !");
    }


} catch (Exception $th) {
    produceError($th->getMessage());
}

?>