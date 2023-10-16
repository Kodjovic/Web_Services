<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

define("DB_USER","root");
define("DB_PASSWORD","");
define("HOST","localhost");
define("DB_NAME","MastClassEcommerce");

$METHODES = [
    "get"=>["description"=>"Lire les données","prefixe"=>"get" ],
    "post"=>["description"=>"Créer les données","prefixe"=>"create" ],
    "put"=>["description"=>"Mettre à jour une données","prefixe"=>"update" ],
    "delete"=>["description"=>"Supprimer une données","prefixe"=>"delete" ],

];

$_ROUTES = ["products", "category", "orders", "users"];


?>