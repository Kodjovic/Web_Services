<?php


class DataLayer{

    private $connexion;

    function __construct()
    {
        $var = "mysql:host=".HOST.";db_name=".DB_NAME;

        try {
            $this->connexion = new PDO($var,DB_USER,DB_PASSWORD);
            // echo "connexion réussie";
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    /*
    *Methode permettantd'authentifier un utilisateur
    * @param UserEntity $user Objet métier décrivant un utilisateur
    * @return UserEntity $user Objet métier décrivant l'tilisateur authentifier
    * @return FALSE En cas d'echec d'authentification
    * @return NULL en cas d'exception déclanchée.
    */ 
    function authentifier(UserEntity $user){
        $sql = "SELECT * FROM `mastclassecommerce`.`customers` WHERE email= :email";

        try {
            $result = $this->connexion->prepare($sql);
            $var= $result->execute(array(
               ':email'=>$user->getEmail()
            ));
            
            $data = $result->fetch(PDO::FETCH_OBJ);

            if ($data && ($data->password == sha1($user->getPassword()))) {
                // Aunthentication réussi
                $user->setIdUser($data->id);
                $user->setSexe($data->sexe);
                $user->setFirstName($data->firstname);
                $user->setLastName($data->lastname);
                $user->setPassword(NULL);
                $user->setAdresseFacturation($data->adresse_facturation);
                $user->setAdresseLivraison($data->adresse_livraison);
                $user->setTel($data->tel);
                $user->setDateBirth($data->dateBirth);

                return $user;
            }else{
                // Authentification échouée
                return FALSE;
            }
        } catch (PDOException $th) {
            // echo 'Erreur : ' . $th->getMessage();
            return NULL;
        }
    }

    /* CREATE */ 

    function createUser(UserEntity $user){
        $sql = "INSERT INTO `mastclassecommerce`.`customers` (sexe,pseudo,email,password,firstname,lastname,dateBirth)
        VALUES (:sexe,:pseudo,:email,:password,:firstname,:lastname,:dateBirth)";
       try {
           $result = $this->connexion->prepare($sql);
            $data = $result->execute(array(
                ':sexe' => $user->getSexe(),
                ':pseudo' => $user->getPseudo(),
                ':email' => $user->getEmail(),
                ':password' => sha1($user->getPassword()),
                ':firstname' => $user->getFirstname(),
                ':lastname' => $user->getLastname(),
                ':dateBirth' => $user->getDateBirth()
            ));
            if($data){
                return TRUE;
            }else{
                return FALSE;
            }
        } catch (PDOException $th) {
            // echo 'Erreur : ' . $th->getMessage();
            return NULL;
        }

    }

    function createCategory(CategoryEntity $category){
        $sql = "INSERT INTO `mastclassecommerce`.`category`(`name`) VALUES (:name)";
        try{
            $result = $this->connexion->prepare($sql);
            $data = $result->execute(array(
                ':name' => $category->getName()
            ));
            if ($data) {
                return TRUE;
            }else{
                return FALSE;
            }
        }catch(PDOException $th) {
            // echo "Erreur de la base de données : " . $th->getMessage();
            return NULL;
        }
    }
    
    function createProduct(ProductEntity $product){
        $sql = "INSERT INTO  `mastclassecommerce`.`product`(`name`, `description`, `price`, `stock`, `category`, `image`)
         VALUES (:name,:description,:price,:stock,:category,:image)";

        // echo $sql;

        try{
            $result = $this->connexion->prepare($sql);
            $data = $result->execute(array(
                ':name' => $product->getName(),
                ':description' => $product->getDescription(),
                ':price' => $product->getPrice(),
                ':stock' => $product->getStock(),
                ':category' => $product->getCategory(),
                ':image' => $product->getImage()
            ));
            if ($data) {
                return TRUE;
            }else{
                return FALSE;
            }
        }catch(PDOException $th) {
            // echo "Erreur de la base de données : " . $th->getMessage();
            return NULL;
        }


    }

    function createOrders(OrdersEntity $orders){
        $sql = "INSERT INTO `mastclassecommerce`.`orders`(`id_customers`, `id_product`, `quantity`, `price`) VALUES 
        (:idCustomers,:idProduct,:quantity,:price)";

        try{
            $result = $this->connexion->prepare($sql);
            $data = $result->execute(array(
                ':idCustomers' => $orders->getIdUser(),
                ':idProduct' => $orders->getIdProduct(),
                ':quantity' => $orders->getQuantity(),
                ':price' => $orders->getPrice(),
            ));
            if ($data) {
                return TRUE;
            }else{
                return FALSE;
            }
        }catch(PDOException $th) {
            // echo "Erreur de la base de données : " . $th->getMessage();
            return NULL;
        }


    }

        /*  READ */ 
    function getUsers(){
        $sql = 'SELECT * FROM `mastclassecommerce`.`customers`';

       try {
            $result = $this->connexion->prepare($sql);
            $var = $result->execute();

            $users = [];
            // PDO::FETCH_OBJ => Force la main et permet d'obtenir un objet
            while ($data = $result->fetch(PDO::FETCH_OBJ)) {
                // Créer un extence user qui va servir à modifier id de user
               $user = new UserEntity();
               $user->setIdUser($data->id);
               $user->setEmail($data->email);
               $user->setSexe($data->sexe);
               $user->setFirstname($data->firstname);
               $user->setLastname($data->lastname);
               $users[] = $user;
            }

            if ($users) {
                return $users;
            }else{
                return FALSE;
            }

       } catch (PDOException $th) {
        return NULL;
       }

        
        /* READ */ 


        /* DELETE */ 
    }

    function getCategory(){
        $sql = 'SELECT * FROM `mastclassecommerce`.`category`';

       try {
            $result = $this->connexion->prepare($sql);
            $var = $result->execute();

            $categories = [];
            // PDO::FETCH_OBJ => Force la main et permet d'obtenir un objet
            while ($data = $result->fetch(PDO::FETCH_OBJ)) {
                // Créer une extence user qui va servir à modifier id de user
               $category = new CategoryEntity();
               $category->setIdCategory($data->id);
               $category->setName($data->name);
               
               $categories[] =  $category;
            }

            if ($categories) {
                return $categories;
            }else{
                return FALSE;
            }

       } catch (PDOException $th) {
        return NULL;
       }

        
        /* READ */ 


        /* DELETE */ 
    }

    function getProduct(){
        $sql = 'SELECT * FROM `mastclassecommerce`.`product`';

       try {
            $result = $this->connexion->prepare($sql);
            $var = $result->execute();

            $products = [];
            // PDO::FETCH_OBJ => Force la main et permet d'obtenir un objet
            while ($data = $result->fetch(PDO::FETCH_OBJ)) {
                // Créer une extence user qui va servir à modifier id de user
               $product = new ProductEntity();
               $product->setIdProduct($data->id);
               $product->setName($data->name); 
               $product->setDescription($data->description); 
               $product->setPrice($data->price);       
               $product->setStock($data->stock);       
               $product->setImage($data->image);       
               $product->setCategory($data->category);       
               $product->setcreatedAt($data->createdat);       
               
               $products[] =  $product;
            }

            if ($products) {
                return $products;
            }else{
                return FALSE;
            }

       } catch (PDOException $th) {
        return NULL;
       }

        
        /* READ */ 


        /* DELETE */ 
    }

    function getOrders(){
        $sql = 'SELECT * FROM `mastclassecommerce`.`orders`';

       try {
            $result = $this->connexion->prepare($sql);
            $var = $result->execute();

            $orders = [];
            // PDO::FETCH_OBJ => Force la main et permet d'obtenir un objet
            while ($data = $result->fetch(PDO::FETCH_OBJ)) {
                // Créer une extence user qui va servir à modifier id de user
               $order = new OrdersEntity();
               $order->setIdOrder($data->id);
               $order->setIdUser($data->id_customers);
               $order->setIdProduct($data->id_product);
               $order->setPrice($data->price);
               $order->setQuantity($data->quantity);     
               $order->setCreatedAt($data->createdat);     
               
               $orders[] =  $order;
            }

            if ($orders) {
                return $orders;
            }else{
                return FALSE;
            }

       } catch (PDOException $th) {
        return NULL;
       }

        
       
    }


    /* UPDATE */ 

    function updateUsers(UserEntity $user){
        $sql = 'UPDATE `mastclassecommerce`.`customers` SET';

        try {
            // Important
            $sql .= " pseudo = '".$user->getPseudo()."',";
            $sql .= " email = '".$user->getEmail()."',";
            $sql .= " sexe = '".$user->getSexe()."',";
            $sql .= " firstname = '".$user->getFirstname()."',";
            $sql .= " lastname = '".$user->getLastname()."',";
            $sql .= " adresse_facturation = '".$user->getAdresseFacturation()."',";
            $sql .= " adresse_livraison = '".$user->getAdresseLivraison()."'";

            $sql .= " WHERE id=".$user->getIdUser();

            $result = $this->connexion->prepare($sql);
            $var = $result->execute();

            if($var){
                return TRUE;
            }else{
                return FALSE;
            }

            // var_dump($sql);
        } catch (PDOException $th) {
            return NULL;
        }
    }
    function updateProduct(ProductEntity $product){
        
        $sql = "UPDATE `mastclassecommerce`.`product` SET `name`=:name, `description`=:description, `price`=:price, `stock`=:stock,
         `category`=:category, `image`=:image WHERE id=:id";

        
        try {
            $result = $this->connexion->prepare($sql);
            $data = $result->execute(array(
                ':id' => $product->getIdProduct(),
                ':name' => $product->getName(),
                ':description' => $product->getDescription(),
                ':price' => $product->getPrice(),
                ':stock' => $product->getStock(),
                ':category' => $product->getCategory(),
                ':image' => $product->getImage()

            ));

            if($data){
                return TRUE;
            }else{
                return FALSE;
            }

            // var_dump($sql);
        } catch (PDOException $e) {
            echo 'Connexion échouée : ' . $e->getMessage();
            return NULL;
        }
    }
    function updateCategory(CategoryEntity $category){
        $sql = "UPDATE `mastclassecommerce`.`category`  SET `name`=:name WHERE id=:id";
        
        // var_dump($sql);
        try {
            $result = $this->connexion->prepare($sql);
            $data = $result->execute(array(
                ':id' => $category->getIdCategory(),
                ':name' => $category->getName(),
            ));
            
            if($data){
                return TRUE;
            }else{
                return FALSE;
            }

        } catch (PDOException $e) {
            echo 'Connexion échouée : ' . $e->getMessage();
            return NULL;
        }
    }
    function updateOrders(OrdersEntity $orders){
        $sql = "UPDATE `mastclassecommerce`.`orders`  SET `id_customers`=:id_customers, `id_product`=:id_product,
        `quantity`=:quantity,`price`=:price WHERE id=:id";
        try {
            $result = $this->connexion->prepare($sql);

            $data = $result->execute(array(
                ':id' => $orders->getIdOrder(),
                ':id_customers' => $orders->getIdUser(),
                ':id_product' => $orders->getIdProduct(),
                ':quantity' => $orders->getQuantity(),
                ':price' => $orders->getPrice(),

            ));
            
            if($data){
                return TRUE;
            }else{
                return FALSE;
            }

        } catch (PDOException $e) {
            return NULL;
        }
    }

        /* DELETE */ 

    function deleteUsers(UserEntity $user){
        $sql = "DELETE FROM `mastclassecommerce`.`customers` WHERE id=".$user->getIdUser();

        try {
           
            $result = $this->connexion->prepare($sql);
            $var = $result->execute();
            // var_dump($sql); exit();
            if($var){
                return TRUE;
            }else{
                return FALSE;
            }

            // var_dump($sql);
        } catch (PDOException $e) {
            echo 'Connexion échouée : ' . $e->getMessage();
            return NULL;
        }
    }
    function deleteProduct(ProductEntity $product){
        $sql = "DELETE FROM `mastclassecommerce`.`product` WHERE id=".$product->getIdProduct();

        try {
           
            $result = $this->connexion->prepare($sql);
            $var = $result->execute();

            if($var){
                return TRUE;
            }else{
                return FALSE;
            }

            // var_dump($sql);
        } catch (PDOException $th) {
            return NULL;
        }
    }
    function deleteCategory(CategoryEntity $category){
        $sql = "DELETE FROM `mastclassecommerce`.`category` WHERE id=".$category->getIdCategory();

        try {
           
            $result = $this->connexion->prepare($sql);
            $var = $result->execute();

            if($var){
                return TRUE;
            }else{
                return FALSE;
            }

            // var_dump($sql);
        } catch (PDOException $th) {
            return NULL;
        }
    }
    function deleteOrders(OrdersEntity $order){
        $sql = "DELETE FROM `mastclassecommerce`.`orders` WHERE id=".$order->getIdOrder();

        try {
           
            $result = $this->connexion->prepare($sql);
            $var = $result->execute();

            if($var){
                return TRUE;
            }else{
                return FALSE;
            }

            // var_dump($sql);
        } catch (PDOException $th) {
            return NULL;
        }
    }


}
?>