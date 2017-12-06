<?php

session_start();
if(!$_SESSION['logado'] or (!isset($_SESSION['id_curso']))){
    header("location:../../view/attention.html?9");
    die();
}
if (empty($_POST['new']) or empty($_POST['url'])) {
    header("location:../../view/attention.html?9");
    die();
}
require '../../include/Defines.php';
require '../../model/ConexaoBD.php';
require '../../model/Read.php';
require '../../model/Create.php';
require '../../model/Lista.php';

$lis = new Lista($_SESSION['idNum']);
$lis->insertAula($_POST['new'],$_POST['url'],  $_SESSION['id_curso']);
header('location:Playlist.php');
