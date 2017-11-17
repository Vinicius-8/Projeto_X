<?php

if (isset($_POST)) {
    require '../include/Config.inc.php';
    $id_login =(string) $_POST['id'];
    $senha_login = (string)md5( $_POST['senha']);
    
    $read = new Read();
    $read->ExecutarRead('aluno', "where id = '{$id_login}'");
    $capturaBanco_aluno = $read->getResultado();
    
    $read->ExecutarRead('professor', "where id = '{$id_login}'");
    $capturaBanco_prof = $read->getResultado();
    
    if (!empty($capturaBanco_aluno)) {
        if ($senha_login == $capturaBanco_aluno[0]['senha']) {
            echo "Aluno logado com sucesso!!";
            echo "<script>alert('Aluno Logado com sucesso!!');</script>";
            echo '<script> window.location.href = "../index.html";</script>';
        }else{
            echo "O aluno não foi logado!, username ou senhas distintas";
            echo "<script>alert('O usuário não foi logado!, username ou senhas distintas');</script>";
            echo '<script>window.location.href = "../view/login.html";</script>';
 
        }
    } elseif( !empty ($capturaBanco_prof) ) {
        
        if ($senha_login == $capturaBanco_prof[0]['senha']) {
            echo "professor logado com sucesso!!";
            echo "<script>alert('professor Logado com sucesso!!');</script>";
            echo '<script> window.location.href = "../index.html";</script>';
        }else{
            echo "O professor não foi logado!, username ou senhas distintas";
            echo "<script>alert('O professor não foi logado!, username ou senhas distintas');</script>";
            echo '<script>window.location.href = "../view/login.html";</script>';
        }
    }
    
    
}else{
    echo "Login vazio!";
}