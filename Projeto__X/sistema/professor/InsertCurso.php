<?php
session_start();

if (!$_SESSION['logado'] and $_SESSION['aluno']) {//verificar se está logado e se é professor
    header("location:../../view/login.html");
    die();
}

if (isset($_POST['cursoid'])) {     //verificar se o curso já foi enviado por post
    $_SESSION['id_curso'] = $_POST['cursoid']; 
    header('location:Playlist.php');
    die();
}
if (!isset($_SESSION['idNum']) or empty($_SESSION['idNum'])) {
    header('location:../../view/attention.html?9');
}
require '../../include/Defines.php';
require '../../model/ConexaoBD.php';
require '../../model/Create.php';
require '../../model/Read.php';

$nome = (string)$_GET['nome'];
$preco = (double) $_GET['preco'];
$desc = (string) $_GET['desc'];

$idNumInsert = $_SESSION['idNum'];

if (empty($idNumInsert) or !isset($idNumInsert) or $idNumInsert == null) {
    //header('location:../../view/attention.html?9');
    var_dump($_SESSION);
    var_dump($idNumInsert);
    die();
}
//inserindo o curso no banco de dados
$create = new Create();
$dados = array('nome_curso'=>$nome,'preco'=>$preco,'descricao'=>$desc,'id_professor'=>$idNumInsert);
$create->ExecutarCreate('curso',$dados);

    
//lendo os cursos do professor
$read = new Read();
$read->setDaft('id');
$read->ExecutarRead('curso', "where id_professor = {$idNumInsert} and nome_curso = '{$nome}'"); 
$_SESSION['id_curso'] = $read->getResultado()[0]['id'];
header('location:Playlist.php');
exit();