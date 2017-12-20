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

$list = new Lista($_SESSION['idNum'],true);          //objeto lista, com o id do professor
$list->getData( $_SESSION['id_curso']);         //pegando dados correspondentes ao id do ursos
$aulas = $list->getAllAulas($_SESSION['id_curso']);     //pegando todas as aulas corespondentes ao curso 
for($i = 0;$i<count($aulas);$i++){
    $aulas[$i]['url'] = explode("=", $aulas[$i]['url'])[1];//separando o que interessa na url
}
$forms = $list->getAllForms($_SESSION['id_curso']);
?>
<!DOCTYPE HTML>
<html lang=”pt-br”>
    <head>
        
        <meta charset=”UTF-8”>
        <link href="css/estilo_playlist.css" rel="stylesheet" type="text/css"/>
        <title><?=$list->getNome()?></title>
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
                    document.getElementById("elemento").submit();   //submit do formulario
                } 
            }
            
            function showAulas(){
                document.getElementById("formularios").style.display = "none";
                document.getElementById("aulas").style.display = "block ";
                
            }
            function showForms(){
                document.getElementById("aulas").style.display = "none";
                document.getElementById("formularios").style.display = "block";
            }
        </script>
    </head>
<body>
    
    <header>        
            <a href="../../index.html"><div class="logo"> 
                <svg> 
                    <symbol id="s-text"> 
                        <text text-anchor="middle" x="50%" y="80%">nect.us</text> </symbol> 
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
                <a href="../../view/sobreNos.html" class="topheader">SOBRE NÓS</a>
                <a href="../../view/faleCon.html" class="topheader">FALE CONOSCO</a>
                <a href="../../view/pergFeq.html" class="topheader">PERGUNTAS FREQUENTES</a>
                <div class="dropdown">
                    <img class="bt-drop" style="max-width: 18px" src="../../view/imagens/t.png">
                    <div class="c-dropdown">
                        <a href="../minhaConta.php" class="d">MINHA CONTA</a>
                        <a href="../sair.php" class="d">SAIR</a>
                    </div>
                </div>
            </div>        
        </header>
    
    <div id="area">
        
        
        <div id="esquerda">            
            <?php                                                               //pegando a thumb correspondente ao curso
            echo "<div id='thumb' style='background-image: url(".$list->getThumb().")'>  
            </div>";
            ?>
            <h2 onclick="showAulas()"  style="cursor: pointer">AULAS: <?= $list->getAulas()?></h2>                 <!--Pegando o numero de aulas-->
            <h2 onclick="showForms()" style="cursor: pointer">FORMULÁRIOS: <?= $list->getForm()?></h2>           <!--Pegando o numero de Formularios--> 
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
                    <form method="POST" action="InsertAula.php" id="elemento">
                        <span id="tit">Aula Nova: </span> <input type="text" name="new" placeholder="Nome" required> 
                        <input type="text" name="url" placeholder="Link do vídeo" required>
                    <button onclick="adicionar()">Adicionar</button>
                    
                    </form>
                </div>
                
                <?php                   //Mostrando todas as aulas já criadas
                            for($i=0;$i<count($aulas);$i++){
                                echo "<div class='um' value='".$aulas[$i]['id']."'> <span class='title'><a href='../Video.php?v=".$aulas[$i]['url']."&a=".$aulas[$i]['nome_aula']."&i=".$aulas[$i]['id']."'>".$aulas[$i]['nome_aula']."</a><span></div>";
                            }
                ?>
                
            </div>
            
            <div id="formularios" style="display:none;">
                <h2>Formulários: </h2>
                
                <!--inserir Formulário-->
                    <form method="POST" action="InsertForm.php" id="elemento">
                        <span id="tito">Novo Formulário: </span> <input style="padding: 1%; font-size: 20px" type="text" name="new" placeholder="Nome do formulário" required> 
                        <input style="padding: 1%; font-size: 20px" type="text" name="url" placeholder="Link do formulário" required>
                    <button id="btn-form" onclick="adicionar()">Adicionar</button>
                    </form>
                
                <?php                   //Mostrando todas formularios já criadas
                            for($i=0;$i<count($forms);$i++){
                                echo "<div class='um' value='".$forms[$i]['id']."'> <span class='title'><a href='".$forms[$i]['url']."'>".$forms[$i]['nome_form']."</a><span></div>";
                            }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
