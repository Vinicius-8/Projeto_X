<?php
session_start();
if((!isset($_SESSION['idNum'])) or (!isset($_SESSION['id_curso']))){
    header("location:../../view/attention.html?9");
    die();
}

     



require '../../include/Defines.php';
require '../../model/ConexaoBD.php';
require '../../model/Read.php';
require '../../model/Lista.php';

$list = new Lista($_SESSION['idNum']);
$list->getData( $_SESSION['id_curso']);
?>
<!DOCTYPE HTML>
<html lang=”pt-br”>
    <head>
        <meta charset=”UTF-8”>
        <link href="css/estilo_playlist.css" rel="stylesheet" type="text/css"/>
        <title>Playlist</title>
        <script>
            function salvar(){
                thumb = document.getElementById("idthumb").value;
                preco = document.getElementById("pre").value;
                desc = document.getElementById("txar").value;
                
                if(thumb!=="" && preco!=="" && desc!==""){
                    document.getElementById('fora').submit();
                }else{
                    alert("Os campos: thumb, preço e descição devem ser preenchidos");
                }
                
            }
        </script>
    </head>
<body>
    
    <div id="area">
        <button id="save" onclick="salvar()">Salvar tudo</button>
        
        <div id="esquerda">
            <?php 
            echo "<div id='thumb' style='background-image: url(".$list->getThumb().")'> 
            </div>";
            ?>
            <h2>Aulas: <?= $list->getAulas()?></h2>
            <h2>Formulários: <?= $list->getForm()?></h2>
            <h2>Alunos: <?= $list->getAlunos()?></h2>
            <h2>Descrição:</h2>
            <textarea name="desc" id="txar" placeholder="sobre o que é esse curso?" form="fora" required></textarea>
            <?php
            echo "<script>
                document.getElementById('txar').value ='".$list->getDesc()."';
            </script>";
            ?>
        </div>
        
        
        <div id="centro">
            <span class="spa">Nome:</span> <span class="spa" style="margin-left: 350px;"><?= $list->getNome()?></span><br><br><br>
            
            <form id="fora" method="POST" action="SaveAll.php">
                <span class="spa">Thumb:</span> <input type="text" name="thumb" id="idthumb" required><br><br><br>
                <span class="spa">Preço:</span> <input type="text" name="preco" id="pre" required>
            </form>
            <?php 
            echo "<script>document.getElementById('pre').value = '".$list->getPreco()."'; document.getElementById('idthumb').value =' ".$list->getThumb() ."'; </script>";
            ?>
           
            <div id="aulas">
                <h2>Aulas: </h2>
                <!--
                <div class="um">
                    <span class="title"><a href="#">Aula 1: Macacos Albinos dos alpes suiços da america latina</a></span>
                </div>
                -->
                <div id="new">
                    
                    <!--inserir aula-->
                    <form method="POST" action="-">
                    <span id="tit">Aula Nova: </span> <input type="text" name="new" placeholder="Nome"> 
                    <input type="text" name="url" placeholder="Link do vídeo">
                    <button>Adicionar</button>
                    
                    </form>
                </div>
                <div>
        </div>
    </div>
</body>
</html>
