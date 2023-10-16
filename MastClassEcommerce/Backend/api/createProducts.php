<?php
require 'commun_services.php';


if (!isset($_REQUEST['name']) || !isset($_REQUEST['description']) || !isset($_REQUEST['price']) ||
!isset($_REQUEST['stock']) || !isset($_REQUEST['category']) || !isset($_REQUEST['image'])) {
    produceErrorRequest();
    return;
}

if (empty($_REQUEST['name']) || empty($_REQUEST['description']) || empty($_REQUEST['price']) ||
empty($_REQUEST['stock']) || empty($_REQUEST['category']) || empty($_REQUEST['image'])) {
    produceErrorRequest();
    return;
}

$product = new ProductEntity();
$product->setName($_REQUEST['name']);
$product->setDescription($_REQUEST['description']);
$product->setPrice($_REQUEST['price']);
$product->setStock($_REQUEST['stock']);
$product->setCategory($_REQUEST['category']);
$product->setImage($_REQUEST['image']);


try {
    $data = $db->createProduct($product);
    if ($data) {
        produceResult("produit enrégistré avec succès");
    }else{
        produceError("problème rencontré lors de l'enrégistrement");
    }


} catch (Exception $th) {
    produceError("Exception déclenchée lors de la création. Merci de réessayer");
}

?>