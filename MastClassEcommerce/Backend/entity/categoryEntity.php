<?php

class CategoryEntity{

    /*
    *Identifiant de la categorie
    */ 
    protected ?int $idCategory;

    /*
    *Le nom de la categorie
    */ 
    protected string $name;


    /*
    * Getter et setter
    */ 
    function getIdCategory() { 
        return $this->idCategory; 
   } 

   function setIdCategory($id) {  
       $this->idCategory = $id; 
   } 

   function getName() { 
        return $this->name; 
   } 

   function setName($name) {  
       $this->name = $name; 
   } 

}



	
?>