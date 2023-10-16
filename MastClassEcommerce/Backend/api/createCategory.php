<?php
require 'commun_services.php';




if (!isset($_REQUEST['name']) || empty($_REQUEST['name'])) {
    produceErrorRequest();
    return;
}

try {
    $category = new CategoryEntity();
    
    $category->setName($_REQUEST['name']);
    // var_dump($category);

    $result = $db->createCategory($category);
    
    if ($result) {
        produceResult("Categorie créee avec succès");
    }else{
        produceError("Echec de création de la Categorie");
    }

} catch (Exception $th) {
    // echo "Erreur : " . $th->getMessage();
   produceError($th->getMessage());
}



?>