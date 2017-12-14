<?php
session_start();
if (!isset($_SESSION['logado']) or !isset($_SESSION['aluno'])){//verificação de existencia de variavel
    header("location:../../index.html");
    die();
}else if (!$_SESSION['logado'] and !$_SESSION['aluno']) { //verificação de logado e se é aluno
    echo "<script>alert('Professor nao logado')</script>";
    header("location:../../view/login.html");
}
require '../../include/Defines.php';
require '../../model/ConexaoBD.php';
require '../../model/Read.php';
require '../../model/Lista.php';

//$_SESSION['id'] é o nickname do aluno na tabela aluno

//Capturando o id [númerico]do aluno 'idNum'
$read = new Read();

$read->setDaft('idNum');    //idNum é o tipo de informação que quero capturar

$read->ExecutarRead('aluno',"where id = '{$_SESSION['id']}'"); //session 'id' é o nickname do aluno na tabela aluno

try {
    $_SESSION['idNum'] = $read->getResultado()[0]['idNum']; //armazenando o id do aluno na variavel de sessao
    
    //capturando o nome do professor
    $read->setDaft('nome');     //tipo de informação que quero capturar
    
    $read->ExecutarRead('aluno',"where idNum = '{$_SESSION['idNum']}'");    //tabela onde quero capturar essa info.
    
    $nome = $read->getResultado()[0]['nome']; //armazenando a informação capturada
    
} catch (Exception $exc) {
    echo $exc->getTraceAsString();
    die();
}
?>
<!DOCTYPE html>
<html lang="pt-br"> 
 <head> 
  <TITLE>Título da página</TITLE> 
  <link href="estilo_logadoAluno.css" rel="stylesheet" type="text/css"/>
 </HEAD> 

 <BODY> 
     <div id="esq">
         <h2><?=$nome?></h2>
         <div id="bot">
             <botton>Meus Cursos</botton> <br>
             <botton>Mais Cursos</botton> 
         </div>
     </div>
     <div id="topo">
         <h2>Meus Cursos</h2>
     </div>
     <div id="cursos">
         1 2 3 4 5 6 7 8 9 10 11 12 13 14 15 16 17 18 19 20 21 22 23 24 25 26 27 28 29 30 31 32 33
     </div>
    </BODY> 
</HTML>
