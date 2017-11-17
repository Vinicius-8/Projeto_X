<?php

if (isset($_POST)) {
    require '../include/Config.inc.php';
    //verificar se o id  já está cadastrado
    $id = (string) strtolower($_POST['id']);
    $read = new Read();

    $read->ExecutarRead('aluno',"where id ='{$id}'");
    $consulta_aluno = $read->getResultado();
    $read->ExecutarRead('professor',"where id ='{$id}'");
    $consulta_prof = $read->getResultado();
    
    if (!empty($consulta_aluno) or !empty($consulta_prof)){ 
        echo "<script>alert('Esse id já foi cadastrado!!');</script>";
        echo '<script> window.location.href = "../view/cadastro.html";</script>';
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


    
    
    //objeto create
    $create = new Create();
    
    //Condicional de [1]Aluno/[2]Professor
    if ($tipo) {
        //Criação do objeto aluno para implementar na insersão do banco de dados
        $aluno = new Aluno($id, $nome, $sobrenome, $nasc, $email, $telefone, md5($senha));
        

        
        $create->ExecutarCreate('projeto_x.aluno', $aluno->getVetor());
        
        echo "Aluno cadastrado com sucesso";
    }else{
        //Criação do objeto Professpr para implementar na insersão do banco de dados
        $prof = new Professor($id, $nome, $sobrenome, $nasc, $email, $telefone, md5($senha));
        
        //inserção dos dados no banco de dados (ah vá)
        $create->ExecutarCreate('projeto_x.professor', $prof->getVetor());
        
        echo "Professor cadastrado com sucesso";
    }
    
    
} else {
    echo "Formulário não preenhido";
}
