<?php 

namespace src\Model;

use src\Database\Connect;
use PDO;

class ModelUser{

    private $first_name;
    private $last_name;
    private $email;
    private $document;


    public function __construct($first_name, $last_name, $email, $document)
    {   
        $this->first_name = (filter_var($first_name, FILTER_SANITIZE_STRING) ? $first_name : NULL);
        $this->last_name = (filter_var($last_name, FILTER_SANITIZE_STRING) ? $last_name : NULL);
        $this->email = (filter_var($email, FILTER_VALIDATE_EMAIL) ? $email : NULL);
        $this->document = (filter_var($document, FILTER_SANITIZE_STRING) ? $document : NULL);
        
    }


    public function required(){

        if(empty($this->first_name) || empty($this->last_name) || empty($this->document)){
            
            Header("Location: listUser.php?mens=error");
            
        }

        if(empty($this->email)){
            Header("Location: listUser.php?mens=errorE");
            
        }

    }

    public function validateUser(){

        if($this->email){

            $sql = "SELECT email FROM users WHERE email = :email";

            $stmt = Connect::getInstance()->prepare($sql);
            $stmt->bindParam(":email", $this->email, PDO::PARAM_STR);
            $stmt->execute();

            if($stmt->rowCount() > 1){

                Header("Location: listUser.php?mens=existE");
                exit();
            }
        
        }

        if($this->document){

            $sql = "SELECT document FROM users WHERE document = :document";
            $stmt = Connect::getInstance()->prepare($sql);
            $stmt->bindParam(":document", $this->document, PDO::PARAM_STR);
            $stmt->execute();

            if($stmt->rowCount() > 1){

                Header("Location: listUser.php?error=existC");
                exit();

            }

        }
    }

    public function validateCpf(){

        $cpf = $this->document;
        
        if(empty($cpf)) {
            
            Header("Location: listUser.php?error=invalidC");
            echo $cpf;
            exit();

        }
        
        if(strlen($cpf) != 11) {

            Header("Location: listUser.php?error=invalidC");
            echo $cpf."esse";
            exit();
          
        }else if($cpf === '00000000000' ||
            $cpf == '11111111111' || 
            $cpf == '22222222222' || 
            $cpf == '33333333333' || 
            $cpf == '44444444444' || 
            $cpf == '55555555555' || 
            $cpf == '66666666666' || 
            $cpf == '77777777777' || 
            $cpf == '88888888888' || 
            $cpf == '99999999999') {
        
            Header("Location: listUser.php?error=invalidC");
            echo $cpf."aqui";
            exit();
            
         } 

         return true;

    }

    //Inserir novo usuário
    public function createUser(){

        //Verificar se o CPF é valido
    //    if($this->validateCpf()){
    //         Header("Location: listUser.php?error=invalidC");
    //         echo "não";
    //         exit();
    //    }

       $this->validateCpf();

        //IMPLEMENTAR BUSCA DO EMAIL
        $this->validateUser();

        $sql = "INSERT INTO users(first_name, last_name, email, document) VALUES(:first_name, :last_name, :email, :document)";

        
        $stmt = Connect::getInstance()->prepare($sql);

        $stmt->bindParam(":first_name", $this->first_name, PDO::PARAM_STR);
        $stmt->bindParam(":last_name", $this->last_name, PDO::PARAM_STR);
        $stmt->bindParam(":email", $this->email, PDO::PARAM_STR);
        $stmt->bindParam(":document", $this->document, PDO::PARAM_STR);

        if($stmt->execute()){

            Header("Location: listUser.php?mens=success");
        
        }else{
        
            Header("Location: listUser.php?error=errorC");
            exit();
        
        }

    }

}