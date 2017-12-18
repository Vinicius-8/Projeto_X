<?php
session_start();
if (!isset($_SESSION['logado']) or !$_SESSION['logado']) { //verificação de logado e se é aluno
    header("location:../view/attention.html?11");
    die();
}else if(!isset($_GET['f'])){
    header("location:minhaConta.php");
}

 
require '../include/Defines.php';
require '../model/ConexaoBD.php';
require '../model/Read.php';

$cond; //variavel de condição
$tabel;//variavel de tabela

$r = new Read();
if ($_SESSION['aluno']) {           //definindo para a consulta do aluno
    $r->setDaft('*');
    $tabel = "inscrito_em";
    $cond = "where id_aluno ='{$_SESSION['idNum']}' and id_curso = '{$_SESSION['id_curso']}'";
} else {                            //definindo para a consulta de professor
    $r->setDaft('nome_curso');
    $tabel = "curso";
    $cond = "where id_professor = '{$_SESSION['idNum']}' and id = '{$_SESSION['id_curso']}'";
}

$r->ExecutarRead($tabel, $cond); //procurando nas tabelas


if (!$r->getResultado()) {
    header("location:../view/attention.html?14");
    die();   
}

$link_form = explode("http", $_GET['f']);
if (count($link_form)<2) {                  //adição do http caso não exista
    $link_form = "http://".$link_form[0];
}else{
    $link_form = $_GET['f'];
}


?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Formulario</title>
        <style>
            iframe {
                width: 1100px;
                height: 500px;
                margin-left: 100px;
                margin-top: 20px;
            }
        </style>
    </head>
    <body>
        <iframe src="<?=$link_form?>"></iframe>
    </body>
</html>
