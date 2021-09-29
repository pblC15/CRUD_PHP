<?php 

require_once __DIR__."\src\Database\Connect.php";
require_once __DIR__."\src\Model\ModelUser.php";

$model = new src\Database\Connect();

$name = trim($_POST['f_firstName']);
$lastName = trim($_POST['f_lastName']);
$email = trim($_POST['f_email']);
$document = trim($_POST['f_cpf']);

// echo "Dados:".$name.", ".$lastName.", ".$email.", ".$document;

$userModel = new src\Model\ModelUser($name, $lastName, $email, $document);

//Insert
if(isset($_POST['f_submit'])){
    // $userModel->createUser();
    $userModel->createUser();   
}

// var_dump(isset($_POST['f_submit']));

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud - PHP</title>
    <link rel='stylesheet' type='text/css' href='css/style.css'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

</head>
<body>
    <header class='cabecalho'>
        <div class='container'>
            <div class='logo'>
                <a href='index.html'>
                    <h1>Logo</h1>
                </a>
            </div>
            <nav class='menu'>
                <ul>
                    <li>Usuários</li>
                    <li>Endereço</li>
                </ul>
            </nav>
        </div> 
    </header>
    <main>
        <section class='mainContent'>
            <div class='listHeader'>
               <h1>Todos os Usuários:</h1>                               
            </div>
            <div class='container1'>
                <div class='formInsert'>
                    <form action='ListUser.php' method='POST' name='f_form'>
                        
                        <div class="form-group">
                            <label for="textFirstName">Nome: </label>
                            <input type="text" name='f_firstName' class="form-control" id="textFirstName" required>
                        </div>
                        <div class="form-group">
                            <label for="textLastName">Sobrenome: </label>
                            <input type="text" name='f_lastName' class="form-control" id="textLastName" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" name='f_email' class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                        </div>
                        <div class="form-group">
                            <label for="textCpf">CPF: </label>
                            <input type="text" name='f_cpf' class="form-control" id="textCpf" pattern="(\d{3}\.?\d{3}\.?\d{3}-?\d{2})|(\d{2}\.?\d{3}\.?\d{3}/?\d{4}-?\d{2})" title="O CPF precisa ter 11 digítos numéricos" required>
                        </div>
                        <button type="submit" name='f_submit' class="btn btn-primary">Cadastrar</button>
                    </form>
                </div>
                <div class='listUser'>
                <?php 
                    
                    $stmt = $model->getInstance()->prepare("SELECT * FROM users ORDER BY id DESC LIMIT 8");
                    $stmt->execute();
                    
                    echo "<table class='table table-striped'>
                            <thead class='table-dark'>
                                <tr>
                                    <th scope='col'>Nome</th>
                                    <th scope='col'>Sobrenome</th>
                                    <th scope='col'>E-mail</th>
                                    <th scope='col'>CPF</th>
                                </tr>
                            </thead>
                        <tbody>";
                    foreach($stmt->fetchAll() as $user){
                        echo "<tr>
                                <th scope='row'>{$user->first_name}</th>
                                <td>{$user->last_name}</td>
                                <td>{$user->email}</td>
                                <td>{$user->document}</td>
                              </tr>";
                    }
                    
                    echo "</tbody>
                    </table>";

                    echo "
                            <nav aria-label='Page navigation example'>
                                <ul class='pagination justify-content-center'>
                                    <li class='page-item'><a class='page-link' href='#'>Previous</a></li>
                                    <li class='page-item'><a class='page-link' href='#'>1</a></li>
                                    <li class='page-item'><a class='page-link' href='#'>2</a></li>
                                    <li class='page-item'><a class='page-link' href='#'>3</a></li>
                                    <li class='page-item'><a class='page-link' href='#'>Next</a></li>
                                </ul>
                            </nav>
                        ";
                ?>
                </div>

        </section>
    </main>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    <script type='text/javascript' src="js/jquery.js"></script>
    <script type='text/javascript' src="js/jquery.mask.js"></script>
    <script type='text/javascript' src="js/script.js"></script>
    <?php

    if($_GET['error'] == "invalidC"){
        echo "<script src='https://unpkg.com/sweetalert/dist/sweetalert.min.js'></script>
                <script>
                swal('Error', 'CPF invalido favor tente novamente!', 'error');
                </script>";
    }
    if($_GET['error'] == "existC"){
        echo "<script src='https://unpkg.com/sweetalert/dist/sweetalert.min.js'></script>
                <script>
                swal('Error', 'CPF já existe, favor tente novamente!', 'error');
                </script>";
    }
    if($_GET['mens'] == "success"){
        echo "<script src='https://unpkg.com/sweetalert/dist/sweetalert.min.js'></script>
                <script>
                swal('success', 'Usuário cadastrado com sucesso!', 'success');
                </script>";
    }
    
    ?>
</body>
</html>