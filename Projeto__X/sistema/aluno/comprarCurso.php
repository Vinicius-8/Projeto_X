<?php
session_start();
echo "idCurso: ".$_POST['cursoid'];

var_dump(isset($_SESSION['logado']));
var_dump(isset($_SESSION['aluno']));

if (!isset($_SESSION['logado']) or !isset($_SESSION['aluno'])){//verificação de existencia de variavel
    header("location:../../view/attention.html?11");
    die();
}

require '../../include/Defines.php';
require '../../model/ConexaoBD.php';
require '../../model/Create.php';

echo "idNUm do Aluno = ".$_SESSION['idNum'];

$creat = new Create();
