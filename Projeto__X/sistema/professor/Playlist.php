<?php
session_start();

if((!isset($_SESSION['idNum'])) or (!isset($_SESSION['id_curso']))){ ///verificação do id do professor e do id do curso
    header("location:../../view/attention.html?9"); // occorreu um problema
    die();
}

require '../../include/Defines.php';        //classes necessárias
require '../../model/ConexaoBD.php';
require '../../model/Read.php';
require '../../model/Lista.php';

$list = new Lista($_SESSION['idNum']);          //objeto lista, com o id do professor
$list->getData( $_SESSION['id_curso']);         //pegando dados correspondentes ao id do ursos
$aulas = $list->getAllAulas($_SESSION['id_curso']);     //pegando todas as aulas corespondentes ao curso 

for($i = 0;$i<count($aulas);$i++){
    $aulas[$i]['url'] = explode("=", $aulas[$i]['url'])[1];//separando o que interessa na url
}
//$aulas[0]['url'] = "https://www.youtube.com/embed/".$aulas[0]['url'];

?>
<!DOCTYPE HTML>
<html lang=”pt-br”>
    <head>
        <meta charset=”UTF-8”>
        <link href="css/estilo_playlist.css" rel="stylesheet" type="text/css"/>
        <title>Playlist</title>
        <script>
            function salvar(){                                      //metodo para salvar todas as modificações
                thumb = document.getElementById("idthumb").value;   //thumb
                preco = document.getElementById("pre").value;       //preço
                desc = document.getElementById("txar").value;       //text Area
                
                if(thumb!=="" && desc!=="" && (preco!=="" || preco===0)){          //verificação de preenchimento de todos os campos
                    document.getElementById('fora').submit();       //submit do formulario
                }else{
                    alert("Os campos: thumb, preço e descição devem ser preenchidos"); //caso exista campo vazio
                }
            }
            
            function adicionar(){                               //metodo para adicionar uma nova aula no curso
                niu = document.getElementById("new").value;     //nome da aula 
                url = document.getElementById("url").value;     //url da aula
                
                if (niu!=="" && url!=="") {                     //verificação de preenchimento dos campos
                    document.getElementById("aula").submit();   //submit do formulario
                } 
            }
        </script>
    </head>
<body>
    
    <div id="area">
        
        
        <div id="esquerda">            
            <?php                                                               //pegando a thumb correspondente ao curso
            echo "<div id='thumb' style='background-image: url(".$list->getThumb().")'>  
            </div>";
            ?>
            <h2>AULAS: <?= $list->getAulas()?></h2>                 <!--Pegando o numero de aulas-->
            <h2>FORMULÁRIOS: <?= $list->getForm()?></h2>           <!--Pegando o numero de Formularios--> 
            <h2>ALUNOS: <?= $list->getAlunos()?></h2>               <!--Pegando o numero de alunos-->
            <h2>DESCRIÇÃO:</h2>
            <textarea name="desc" id="txar" placeholder="sobre o que é esse curso?" form="fora" required></textarea>
            <?php                                                                   //Escrevendo a descrição do curso
            echo "<script>  
                document.getElementById('txar').value ='".$list->getDesc()."';      
            </script>";
            ?>
        </div>
        
        
        <div id="centro">
            <div id="top">
                <span class="spa"></span> <span class="titulo_curso"><b><?= $list->getNome()?></b></span><button id="save" onclick="salvar()">Salvar tudo</button><br>

                <form id="fora" method="POST" action="SaveAll.php">
                    <span class="sp">Thumb:</span><input type="text" name="thumb" id="idthumb" required><br>
                    <span class="sp">Preço:</span><input type="number" name="preco" id="pre" required>
                </form>
                <?php                                               //preço do curso
                echo "<script>document.getElementById('pre').value = '".$list->getPreco()."'; document.getElementById('idthumb').value =' ".$list->getThumb() ."'; </script>";
                ?>
            </div>
            
            <div id="aulas">
                <h2>Aulas: </h2>
                
                <div id="new">
                    
                    <!--inserir aula-->
                    <form method="POST" action="InsertAula.php" id="aula">
                        <span id="tit">Aula Nova: </span> <input type="text" name="new" placeholder="Nome" required> 
                        <input type="text" name="url" placeholder="Link do vídeo" required>
                    <button onclick="adicionar()">Adicionar</button>
                    
                    </form>
                </div>
                
                <?php                   //Mostrando todas as aulas já criadas
                            for($i=0;$i<count($aulas);$i++){
                                echo "<div class='um' value='".$aulas[$i]['id']."'> <span class='title'><a href='../Video.php?v=".$aulas[$i]['url']."'>".$aulas[$i]['nome_aula']."</a><span></div>";
                            }
                ?>
                
            </div>
        </div>
    </div>
</body>
</html>
