<?php
/**
 * Description of insertComent
 *
 * @author Vinicius
 */
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

var_dump($_POST);
var_dump($_SESSION);
$create = new Create();
$com = array('texto'=>$_POST['coment'],'id_aula'=>$_POST['id_aula'],'id_aluno'=>$_SESSION['idNum'],'id_professor'=>$_POST['prof']);
$create->ExecutarCreate('comentario', $com);
header('Location: ' . $_SERVER['HTTP_REFERER']);