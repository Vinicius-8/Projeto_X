<?php
session_start();
//testar se ele já estiver cadastrado
if (!isset($_SESSION['logado']) or !isset($_SESSION['aluno'])){//verificação de existencia de variavel
    header("location:../../view/attention.html?11");
    die();
}
require '../../include/Defines.php';
require '../../model/ConexaoBD.php';
require '../../model/Create.php';
require '../../model/Read.php';
$id_curso = $_POST['cursoid'];

$readi = new Read();
$readi->setDaft('*');
$readi->ExecutarRead('inscrito_em',"where id_curso = '{$id_curso}' and id_aluno = '{$_SESSION['idNum']}'"); //consultando a tabela inscrito_em 
if ($readi->getResultado()) {                       //se o usuário já pussuir o curso ele é redirecionado
    header("location:../../view/attention.html?12");
    die();
}

$creat = new Create();
$data = array('id_aluno'=>$_SESSION['idNum'],'id_curso'=>$id_curso);

$creat->ExecutarCreate('inscrito_em', $data); //inserindo a compra no BD
header("location:../../view/attention.html?13");
die();