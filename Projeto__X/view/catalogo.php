<?php

require '../include/Defines.php';
require '../model/ConexaoBD.php';
require '../model/Read.php';
require '../model/Listagem.php';
$listagem = new Listagem();
$cursos = $listagem->listagemParcial();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="css/estilo_catalogo.css" rel="stylesheet" type="text/css"/>
        <title>Catalogo de Cursos</title>
        <script>
            function select(idCurso){       //metodo que abre o curso correspondente ao clicado, enviando atraves de um formulario os dados necessarios
                document.write("<form method='POST' action='curso.php' id='mular' style='display:none'><input type='text' name='cursoid' value='"+idCurso +"'> </form>");
                document.getElementById('mular').submit();  //submit do formulario
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
            </div>
        
        </header>
        
        <h1>Nossos cursos</h1>
        
        <div id="cursos">
            <?php
                     //listagem de todos os cursos de um determinado professor, que incluem thumb, nome e id
                
                   for($i = 0; $i<count($cursos); $i++){
                        echo "<div class='container' onclick='select(".$cursos[$i]['id'].")' >
                    <img src='".$cursos[$i]['thumb']."'  alt='Thumb do Curso'> "
                                . "<div class='fade'><a>".$cursos[$i]['nome_curso']."</a></div></div>";
                    }
                    
                
            ?>
        </div>
        
        <footer>
            <p>'nome do site' &#9400  2017<br>Desenvolvido por Vinicius Araújo e Luis Santos</p>
    </footer>
    </body>
</html>
