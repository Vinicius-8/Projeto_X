<?php
session_start();
if (!isset($_SESSION['logado']) or !isset($_SESSION['aluno'])){//verificação de existencia de variavel
    header("location:../../index.html");
    die();
}else if (!$_SESSION['logado'] or !$_SESSION['aluno']) { //verificação de logado e se é aluno
    header("location:../../view/login.html");
    die();
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

$lis = new Lista( $_SESSION['idNum'],false);
$cursos = $lis->getAllCursos();
?>
<!DOCTYPE html>
<html lang="pt-br"> 
 <head> 
  <TITLE>Título da página</TITLE> 
  <link href="css/estilo_logadoAluno.css" rel="stylesheet" type="text/css"/>
  <script>
      function select(idCurso){       //metodo que abre o curso correspondente ao clicado, enviando atraves de um formulario os dados necessarios
                document.write("<form method='POST' action='../../view/Curso.php' id='mular' style='display:none'><input type='text' name='cursoid' value='"+idCurso +"'> </form>");
                document.getElementById('mular').submit();  //submit do formulario
            }
  </script>
 </HEAD> 

 <BODY> 
     <div id="esq">
         <h2><?=$nome?></h2>
         <div id="bot">
             <botton>Meus Cursos</botton> <br>
             <botton ><a href="../../view/catalogo.php">Mais Cursos<a></botton> 
         </div>
     </div>
     <div id="topo">
         <h2>Meus Cursos</h2>
     </div>
     <div id="cursos">
         <?php     //listagem de todos os cursos de um determinado professor, que incluem thumb, nome e id
                
                   for($i = 0; $i<count($cursos); $i++){
                        echo "<div class='container' onclick='select(".$cursos[$i]['id'].")' >
                    <img src='".$cursos[$i]['thumb']."'  alt='Thumb do Curso'> "
                                . "<div class='fade'><a>".$cursos[$i]['nome_curso']."</a></div></div>";
                    }
                    
                ?>
     </div>
    </BODY> 
</HTML>
