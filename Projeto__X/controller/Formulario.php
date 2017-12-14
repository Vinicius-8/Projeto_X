<?php
session_start();
if (isset($_POST)) {
    require '../include/Config.inc.php';
    //verificar se o id  já está cadastrado
    $id = (string) strtolower($_POST['id']);
    $read = new Read();

    $read->ExecutarRead('aluno',"where id ='{$id}'");
    $consulta_aluno = $read->getResultado();
    if (!$consulta_aluno) {
        $read->ExecutarRead('professor',"where id ='{$id}'");
        $consulta_prof = $read->getResultado();
    }
    
    
    if (!empty($consulta_aluno) or !empty($consulta_prof)){ 
        echo "<script>window.location.href = '../view/attention.html?5';</script>";
        die();
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
        echo "<script>window.location.href = '../view/attention.html?3';</script>";
        die;          
    }
    
    
    //captura dos demais valores
    $tipo = (boolean) ($_POST['tipo'] == 0 ) ? true : false; //é aluno?
    $nome = (string) $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];
    
    $nasc = $_POST['nasc'];
    $nasc = explode('/', $nasc);     // transformando a data em vetor
    $nasc = array_reverse($nasc); // invertendo as posicoes do vetor, para atender o padrão de data do banco
    $nasc = implode('-', $nasc);     // transformando em string de novo
    $telefone = (string) $_POST['telefone'];


    
    
    //objeto create
    $create = new Create();
    
    //Condicional de [1]Aluno/[2]Professor
    if ($tipo) {
        $aluno = array('id'=> $id, 'nome'=> $nome, 'sobrenome'=> $sobrenome, 'data_nasc'=> $nasc, 'email'=> $email, 'telefone'=> $telefone, 'senha'=> md5($senha));
        $create->ExecutarCreate('aluno', $aluno);
        //aluno cadastrado com sucesso      
        $_SESSION['id'] = $id;
        $_SESSION['logado'] = true;
        $_SESSION['aluno'] = true;
        echo "<script>window.location.href = '../view/attention.html?0';</script>";
        die();
        
    }else{
        $prof = array('id'=> $id, 'nome'=> $nome, 'sobrenome'=> $sobrenome, 'data_nasc'=> $nasc, 'email'=> $email, 'telefone'=> $telefone, 'senha'=> md5($senha));
        //inserção dos dados no banco de dados (ah vá)
        $create->ExecutarCreate('professor', $prof);
        
        $_SESSION['id'] = $id;
        $_SESSION['logado'] = true;
        $_SESSION['aluno'] = false;
        //professor cadastrado com sucesso
        echo "<script>window.location.href = '../view/attention.html?1';</script>";
        die();
    }
    
    
    
} else {
    //formulario vazio
    echo "<script>window.location.href = '../view/attention.html?3';</script>";
}
