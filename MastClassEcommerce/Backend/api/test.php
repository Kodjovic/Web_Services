<?php
require 'commun_services.php';
$user = new UserEntity();
$user->setEmail("contact@gmail.com");
$user->setPassword("contact");
produceResult($user);
// var_dump(clearData($user));


// produceErrorAuth("Erreur de test");





?>