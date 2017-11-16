<?php

if (isset($_POST)) {
    require '../include/Config.inc.php';
    $cpf_login =(string) $_POST['cpf'];
    $senha_login = (string)md5( $_POST['senha']);
    
    $read = new Read();
    $read->setPwd(', senha');
    $read->ExecutarRead('aluno');
    $dados = $read->getResultado();
    
    for($i=0;$i<count($dados);$i++){    
        
        if ($dados[$i]['cpf']==$cpf_login && $dados[$i]['senha'] == $senha_login) {
           
            echo "<script>alert('Usuário Logado com sucesso!!');</script>";
            echo "uSuário logado com sucesso";
            
            echo '<script>
            window.location.href = "../index.html";</script>';
        } 
    }
    echo "Senha incorreta";
    echo "<script>alert('Senha incorreta!!');</script>";
    sleep(2);
     echo '<script>
            window.location.href = "../view/login.html";</script>';
        
    
    
}else{
    echo "Login vazio!";
}