<?php 

require_once __DIR__."/src/Database/Connect.php";
require_once __DIR__."/src/Model/ModelUser.php";

$model = new src\Database\Connect();

//Insert
if(isset($_POST['f_submit'])){

    $name = trim($_POST['f_firstName']);
    $lastName = trim($_POST['f_lastName']);
    $email = trim($_POST['f_email']);
    $document = trim($_POST['f_cpf']);

    $userModel = new src\Model\ModelUser($name, $lastName, $email, $document);

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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
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
                                    <th scope='col'>Deletar</th>
                                    <th scope='col'>Alterar</th>
                                </tr>
                            </thead>
                        <tbody>";
                    foreach($stmt->fetchAll() as $user){
                        echo "<tr>
                                <th scope='row'>{$user->first_name}</th>
                                <td>{$user->last_name}</td>
                                <td>{$user->email}</td>
                                <td>{$user->document}</td>
                                <td class='tdList'><a href='#'>
                                <svg xmlns='http://www.w3.org/2000/svg' width='30' height='30' fill='currentColor' class='bi bi-trash' viewBox='0 0 16 16'>
                                <path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z'/>
                                <path fill-rule='evenodd' d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z'/>
                                </svg>
                                </a></td>
                                <td class='tdList'><a href='#'>
                                <svg xmlns='http://www.w3.org/2000/svg' width='28' height='28' fill='#e60000' class='bi bi-pencil-square' viewBox='0 0 16 16'>
                                <path d='M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z'/>
                                <path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z'/>
                                </svg>
                                </a></td>
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

    if(isset($_GET['error']) == "invalidC"){
        echo "<script src='https://unpkg.com/sweetalert/dist/sweetalert.min.js'></script>
                <script>
                swal('Error', 'CPF invalido favor tente novamente!', 'error');
                </script>";
    }
    if(isset($_GET['error']) == "existC"){
        echo "<script src='https://unpkg.com/sweetalert/dist/sweetalert.min.js'></script>
                <script>
                swal('Error', 'CPF já existe, favor tente novamente!', 'error');
                </script>";
    }
    if(isset($_GET['error']) == "existE"){
        echo "<script src='https://unpkg.com/sweetalert/dist/sweetalert.min.js'></script>
                <script>
                swal('Error', 'E-mail já existe, favor tente novamente!', 'error');
                </script>";
    }
    if(isset($_GET['mens']) == "success"){
        echo "<script src='https://unpkg.com/sweetalert/dist/sweetalert.min.js'></script>
                <script>
                swal('success', 'Usuário cadastrado com sucesso!', 'success');
                </script>";
    }
    
    ?>
</body>
</html>