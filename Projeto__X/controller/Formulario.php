<?php

if (isset($_POST)) {
    require '../include/Config.inc.php';
    //verificar se o id  já está cadastrado
    $id = (string) strtolower($_POST['id']);
    $read = new Read();
<<<<<<< HEAD
    $read->ExecutarRead('aluno');
    $cpfs = $read->getResultado();
    
    for($i=0;$i<count($cpfs);$i++){    
        if ($cpfs[$i]['cpf'] == $cpf) {
            echo "<script>alert('CPF já cadastrado!');</script>";
            sleep(1);
            echo '<script>
            window.location.href = "../view/cadastro.html";</script>';
            exit();
        }
=======
    $read->ExecutarRead('aluno',"where id ='{$id}'");
    $consulta = $read->getResultado();
    if (!empty($consulta)){ 
        echo "<script>alert('Esse id já foi cadastrado!!');</script>";
        echo '<script> window.location.href = "../view/cadastro.html";</script>';
>>>>>>> 543fbd651edd4e354ebe3518a6daa7646dfd65dd
    }
   
    
    //capturando as senhas
    $senha = (string) $_POST['senha'];
    $senha2 = (string) $_POST['senha2'];

    


    //verificação de igualdade de senhas
    if ($senha != $senha2) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);        
    }

    
    
    //verificando o email
    $email = (string) $_POST['email'];
    $validar = new Validar();
    if (!($validar->Email($email))) {
        echo "email inválido";
        die;          
    }
    
    
    //captura dos demais valores
    $tipo = (boolean) ($_POST['tipo'] == 0 ) ? true : false; //é aluno?
    $nome = (string) $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];
    $nasc = (int) $_POST['nasc'];
    $telefone = (integer) $_POST['telefone'];


    
    
    

    //Condicional de [1]Aluno/[2]Professor
    if ($tipo) {
        //Criação do objeto aluno para implementar na insersão do banco de dados
        $aluno = new Aluno($id, $nome, $sobrenome, $nasc, $email, $telefone, md5($senha));
        //objeto create
        $create = new Create();
        //inserção dos dados no banco de dados (ah vá)
        $create->ExecutarCreate('projeto_x.aluno', $aluno->getVetorAluno());
        
        echo "Usuário cadastrado com sucesso";
    }else{
        //professor
    }
    
    
} else {
    echo "Formulário não preenhido";
}
