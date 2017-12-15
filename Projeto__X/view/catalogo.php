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
    </body>
</html>
