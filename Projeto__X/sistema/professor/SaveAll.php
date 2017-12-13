<?php
session_start();

if( empty($_POST['thumb']) or empty($_POST['desc']) or !isset($_POST['preco']) ){
    header("location:../../view/attention.html?9");
    die();
}
require '../../include/Defines.php';
require '../../model/ConexaoBD.php';
require '../../model/Update.php';
$dados = array('preco' => $_POST['preco'], 'descricao' => $_POST['desc'] ,'thumb' => $_POST['thumb']);

$update = new Update();
$update->ExecutarUpdate('curso', $dados, "where id = '{$_SESSION['id_curso']}' and id_professor = '{$_SESSION['idNum']}' "," ");
header("location:../../view/attention.html?10");
sleep(3);

die();

