<?php
session_start();
if (!isset($_SESSION['logado']) or !$_SESSION['logado'] ) { //verificação de logado e se é aluno
    header("location:../view/attention.html?11");
    die();
}else if(!$_POST){      //caso post vazio retorne pra pag da onde veio
    header('Location: ' . $_SERVER['HTTP_REFERER']);     
}

require '../include/Defines.php';
require '../model/ConexaoBD.php';
require '../model/Create.php';
$tre = new Create();
$aff = array('id_comentario' =>$_POST['comentid'],'texto_sub'=>$_POST['resposta'],'autor'=>$_POST['autor']);
$tre->ExecutarCreate('sub_comentario', $aff);
echo "opa";
header('Location: ' . $_SERVER['HTTP_REFERER']);
