<?php
session_start();
if(!isset($_POST['cursoid']) or empty($_POST['cursoid'])){
    header("location:catalogo.php");
}
require '../include/Defines.php'; 
require '../model/ConexaoBD.php';
require '../model/Read.php';
require '../model/Listagem.php';


$idCurso = $_POST['cursoid']; //capturando o id do curso

$_SESSION['id_curso'] = $idCurso;//definindo na sessão

$lista = new Listagem(); //objeto listagem
$lista->listagemCompleta($idCurso); //listagem completa do curso
$aulas = $lista->getAllAulas($idCurso);
for($i = 0;$i<count($aulas);$i++){
    $aulas[$i]['url'] = explode("=", $aulas[$i]['url'])[1];//separando o que interessa na url
}
$forms = $lista->getAllForms($idCurso); //pegando todos os formulários
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
            function showForms(){
                document.getElementById("direit").style.display = "none";
                document.getElementById("direit2").style.display = "block";
            }
            function showAulas(){
                document.getElementById("direit2").style.display = "none";
                document.getElementById("direit").style.display = "block";
            }
        </script>
    </head>
    <body>
        
        <header>        
            <a href="../index.html"><div class="logo"> 
                <svg> 
                    <symbol id="s-text"> 
                        <text text-anchor="middle" x="50%" y="80%">generico</text> </symbol> 
                    <g> 
                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#s-text" class="titulo_text"></use> 
                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#s-text" class="titulo_text"></use> 
                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#s-text" class="titulo_text"></use> 
                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#s-text" class="titulo_text"></use> 
                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#s-text" class="titulo_text"></use> 
                    </g> 
                </svg> 
        </div></a>
        
        <div class="links">
            <a href="sobreNos.html" class="topheader">SOBRE NÓS</a>
            <a href="faleCon.html" class="topheader">FALE CONOSCO</a>
            <a href="pergFeq.html" class="topheader">PERGUNTAS FREQUENTES</a>
            <div class="dropdown">
                <img class="bt-drop" style="max-width: 18px" src="imagens/t.png">
                <div class="c-dropdown">
                    <a href="../sistema/minhaConta.php" class="d">MINHA CONTA</a>
                    <a href="../sistema/sair.php" class="d">SAIR</a>
                </div>
            </div>
        </div>
        
    </header>
        
        <div id="esquer">
            <?php                                                               //pegando a thumb correspondente ao curso
            echo "<div id='thumb' style='background-image: url(".$lista->getThumb().")'>  
            </div>";
            
            ?>
            <h1><?=$lista->getNome()?></h1><br>
            <h2>Preço: R$ <?=$lista->getPreco()?>,00</h2><br>
            <span class="pan" onclick="showAulas()"style="cursor: pointer;">AULAS: <?=$lista->getAulas()?></span> <span class="pan" onclick="showForms()" style="cursor: pointer;">FORMULÁRIOS: <?= $lista->getForm()?></span> <span class="pan">ALUNOS: <?=$lista->getAlunos()?></span><br>
            <br><span class="pan">DESCRIÇÃO:</span><br><span id="desc"><?=$lista->getDesc()?></span><br><span class="pan">Autor: <?=$lista->getNomeAutor()?> <?=$lista->getSobrenome()?> - <?= $lista->getNasc()?></span><br>
            <br><button onclick="select(<?=$idCurso?>)">COMPRAR CURSO</button>
        </div>
        <div id="direit">
            <?php                   //Mostrando todas as aulas já criadas
                            for($i=0;$i<count($aulas);$i++){
                                echo "<div class='um' value='".$aulas[$i]['id']."'> <span class='title'><a href='../sistema/Video.php?v=".$aulas[$i]['url']."&a=".$aulas[$i]['nome_aula']."'>".$aulas[$i]['nome_aula']."</a><span></div>";
                            }
                ?>
        </div>
        <div id="direit2" style="display: none;">
            <?php                   //Mostrando todas as aulas já criadas
                            for($i=0;$i<count($forms);$i++){
                                echo "<div class='um' value='".$forms[$i]['id']."'> <span class='title'><a href='".$forms[$i]['url']."'>".$forms[$i]['nome_form']."</a><span></div>";
                            }
                ?>
        </div>
    </body>
</html>
