<?php 

namespace src\Model;

//Verificar erros 
ini_set('display_errors', 1);
error_reporting(E_ALL);

use src\Database\Connect;
use PDO;

class ModelUser{

    private $first_name;
    private $last_name;
    private $email;
    private $document;


    public function __construct($first_name, $last_name, $email, $document)
    {   
        $cpfFirst = (filter_var($document, FILTER_SANITIZE_STRING) ? $document : NULL);
        $cpf = preg_replace("/[^0-9]/", "", $cpfFirst);
        $this->document = $cpf;
        $this->first_name = (filter_var($first_name, FILTER_SANITIZE_STRING) ? $first_name : NULL);
        $this->last_name = (filter_var($last_name, FILTER_SANITIZE_STRING) ? $last_name : NULL);
        $this->email = (filter_var($email, FILTER_VALIDATE_EMAIL) ? $email : NULL);       
        
    }


public function required(){

        if(empty($this->first_name) || empty($this->last_name) || empty($this->document)){
            
            Header("Location: listUser.php?mens=error");
            
        }

        if(empty($this->email)){
            Header("Location: listUser.php?mens=errorE");
            
        }

    }

    //Verifica se o email ou CPF já existe
    public function validateUser(){
       
        //Verifica se email existe
        if($this->email){

            $sql = "SELECT * FROM users WHERE email = :email";

            $stmt = Connect::getInstance()->prepare($sql);
            $stmt->bindParam(":email", $this->email, PDO::PARAM_STR);
            $stmt->execute();

            if($stmt->rowCount() >= 1){

                Header("Location: listUser.php?error=existE");
                exit();
            }
        
        }

        if($this->document){

            $sql = "SELECT * FROM users WHERE document = :document";
            $stmt = Connect::getInstance()->prepare($sql);
            $stmt->bindParam(":document", $this->document, PDO::PARAM_STR);
            $stmt->execute();

            // var_dump($stmt);
            // echo "<br>".$cpf."<br>".$sql;
            // exit();

            if($stmt->rowCount() >= 1){

                Header("Location: listUser.php?error=existC");
                exit();

            }

        }
    }

    public function validateCpf(){

        $cpf = $this->document;
        
        if(empty($cpf)) {
            
            Header("Location: listUser.php?error=invalidC");
            exit();

        }
        
        if(strlen($cpf) != 11) {

            Header("Location: listUser.php?error=invalidC");
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
            exit();
            
         } 

         return true;

    }

    //Inserir novo usuário
    public function createUser(){


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