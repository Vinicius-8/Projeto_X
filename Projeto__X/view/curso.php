<?php
if(!isset($_POST['cursoid']) or empty($_POST['cursoid'])){
    header("location:catalogo.php");
}
require '../include/Defines.php'; 
require '../model/ConexaoBD.php';
require '../model/Read.php';
require '../model/Listagem.php';


$idCurso = $_POST['cursoid']; //capturando o id do curso

$lista = new Listagem(); //objeto listagem
$lista->listagemCompleta($idCurso); //listagem completa do curso
$aulas = $lista->getAllAulas($idCurso);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Curso</title>
        <link href="css/estilo_curso.css" rel="stylesheet" type="text/css"/>
         <script>
            function select(idCurso){       //metodo que abre o curso correspondente ao clicado, enviando atraves de um formulario os dados necessarios
                document.write("<form method='POST' action='../sistema/aluno/comprarCurso.php' id='mular' style='display:none'><input type='text' name='cursoid' value='"+idCurso +"'> </form>");
                document.getElementById('mular').submit();  //submit do formulario
            }
        </script>
    </head>
    <body>
        <div id="esquer">
            <?php                                                               //pegando a thumb correspondente ao curso
            echo "<div id='thumb' style='background-image: url(".$lista->getThumb().")'>  
            </div>";
            
            ?>
            <h1><?=$lista->getNome()?></h1><br>
            <h2>Preço: <?=$lista->getPreco()?></h2><br>
            <span class="pan">Aulas:<?=$lista->getAulas()?></span> <span class="pan">Formularios:0</span> <span class="pan">Alunos:0</span><br>
            <br><span class="pan">descrição:</span><br><span id="desc"><?=$lista->getDesc()?></span>
            <button onclick="select(<?=$idCurso?>)">Comprar Curso</button>
        </div>
        <div id="direit">
            <?php                   //Mostrando todas as aulas já criadas
                            for($i=0;$i<count($aulas);$i++){
                                echo "<div class='um' value='".$aulas[$i]['id']."'> <span class='title'><a href='../Video.php?v=".$aulas[$i]['url']."&a=".$aulas[$i]['nome_aula']."'>".$aulas[$i]['nome_aula']."</a><span></div>";
                            }
                ?>
        </div>
    </body>
</html>
