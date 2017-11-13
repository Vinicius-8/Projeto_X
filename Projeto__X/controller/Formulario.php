<?php


if (isset($_POST)) {
    $tipo = (boolean) ($_POST['tipo'] == 0 )? true: false; //é aluno?
    
    $nome = (string)$_POST['nome'];
    
    $sobrenome = $_POST['sobrenome'];
    
    $nasc = (int)$_POST['nasc'];
    
    $email = (string)$_POST['email'];
    
    $telefone = (integer) $_POST['telefone'];
    
    
    echo "Nome: ".$nome."<br>Sobrenome: ".$sobrenome."<br>Data de nascimento: ".$nasc;
    echo "<br>Email: ".$email."<br>Telefone: ".$telefone."<br> É aluno: ".$tipo ;
    
    if ($tipo) {
        require '../include/Config.inc.php';
        $aluno = new Aluno();
    }
}else{
    echo "Error de nao ter nada";
}
