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

//capturando os comentários
$read->setDaft('c.id,texto,nome,sobrenome,nome_aula');
$read->ExecutarRead('comentario',"c join aluno a on c.id_aluno = a.idNum join aula l on l.id = c.id_aula where id_aluno = '{$_SESSION['idNum']}'order by id desc");
$coments = $read->getResultado();

?>
<!DOCTYPE html>
<html lang="pt-br"> 
 <head> 
  <TITLE>Título da página</TITLE> 
  <link href="css/estilo_logadoAluno.css" rel="stylesheet" type="text/css"/>
  <style>
      #forum .coment .resp  {
                display: none;
            } 
  </style>
  <script src="script/script_logadoAluno.js"></script>
  <script>
      function select(idCurso){       //metodo que abre o curso correspondente ao clicado, enviando atraves de um formulario os dados necessarios
                document.write("<form method='POST' action='../../view/Curso.php' id='mular' style='display:none'><input type='text' name='cursoid' value='"+idCurso +"'> </form>");
                document.getElementById('mular').submit();  //submit do formulario
            }
            function turn(num){
                document.getElementById('resp'+num).style.display ='block';
                document.getElementById('rep'+num).style.display ='none';
                
            }
            

  </script>
 </HEAD> 

 <BODY> 
     <div id="esq">
         <h2><?=$nome?></h2>
         <div id="bot">
             <botton onclick="cursosDiv()">Meus Cursos</botton> <br>
             <botton ><a href="../../view/catalogo.php">Mais Cursos<a></botton> 
                         <botton onclick="forumDiv()">Fórum<a></botton> 
         </div>
     </div>
     <div id="topo">
         <h2 id="title">Fórum</h2>
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
     <div id="forum">
         <!--listagem dos comentarios-->
                
                <?php
                for($i = 0; $i<count($coments);$i++){
                    echo "<div class='coment'>"
                    . "<span class='autor'>Aula: ".$coments[$i]['nome_aula'].""
                            . "<br>"
                            . "<br>"
                            .$coments[$i]['nome']." ". $coments[$i]['sobrenome'].": </span>"
                            . "<br>"
                            . "<span class='com'>".$coments[$i]['texto']."</span>"
                            . "<br>"
                            . "<form method='post' action='../insertSub.php' class='resp' id='resp".$coments[$i]['id']."'>"
                            . "<input type='hidden' name='comentid' value='".$coments[$i]['id']."'>"
                            . "<input type='hidden' name='autor' value='".$_SESSION['id']."'>"
                            . "<input type='text' name='resposta' placeholder='Resposta' required>"
                            . "<input type='submit'>"
                            . "</form>"
                            . "<button id='rep".$coments[$i]['id']."' onclick='turn(".$coments[$i]['id'].")'>Responder</button>";
                    
                    $read->setDaft("texto_sub,autor");
                    $read->ExecutarRead('sub_comentario',"where id_comentario = '".$coments[$i]['id']."'");
                    $sub = $read->getResultado();
                    for($j = 0;$j< count($sub);$j++){
                        echo "<br><br><span class='sub_rep'> ~".$sub[$j]['autor']."~: ".$sub[$j]['texto_sub']."</span>";
                    }
                    echo "</div>";
                }
                
                ?>
     </div>
    </BODY> 
</HTML>
