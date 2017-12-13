<?php
session_start();

if (!$_SESSION['logado'] and $_SESSION['aluno']) {
    echo "<script>alert('Professor nao logado')</script>";
    header("location:../../view/login.html");
    die();
}

if (isset($_POST['cursoid'])) {
    $_SESSION['id_curso'] = $_POST['cursoid']; 
    header('location:Playlist.php');
    die();
}


require '../../include/Defines.php';
require '../../model/ConexaoBD.php';
require '../../model/Create.php';
require '../../model/Read.php';

$nome = (string)$_GET['nome'];
$preco = (double) $_GET['preco'];
$desc = (string) $_GET['desc'];

//inserindo o curso no banco de dados
$create = new Create();
$dados = array('nome_curso'=>$nome,'preco'=>$preco,'descricao'=>$desc,'id_professor'=>$_SESSION['idNum']);
$create->ExecutarCreate('curso',$dados);


//lendo os cursos do professor
$read = new Read();
$read->setDaft('id');
$read->ExecutarRead('curso', "where id_professor = {$_SESSION['idNum']} and nome_curso = '{$nome}'"); 
$_SESSION['id_curso'] = $read->getResultado()[0]['id'];
header('location:Playlist.php');
exit;