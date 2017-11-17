<?php

if (isset($_POST)) {
    require '../include/Config.inc.php';
    $id_login =(string) $_POST['id'];
    $senha_login = (string)md5( $_POST['senha']);
    
    $read = new Read();
    $read->ExecutarRead('aluno', "where id = '{$id_login}'");
    $capturaBanco = $read->getResultado();
   
    
    if (!empty($capturaBanco)) {
        if ($senha_login == $capturaBanco[0]['senha']) {
            echo "Usuário logado com sucesso!!";
            echo "<script>alert('Usuário Logado com sucesso!!');</script>";
            echo '<script> window.location.href = "../index.html";</script>';
        }else{
            
            echo "O usuário não foi logado!, username ou senhas distintas";
            echo "<script>alert('O usuário não foi logado!, username ou senhas distintas');</script>";
            echo '<script>window.location.href = "../view/login.html";</script>';
 
        }
    } else {
        echo "Usuario não cadastrado";
    }
    die;
    
}else{
    echo "Login vazio!";
}