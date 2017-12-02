<?php
session_start();

if (!$_SESSION['logado'] and $_SESSION['aluno']) {
    echo "<script>alert('Professor nao logado')</script>";
    header("location:../../view/login.html");
    die();
}
require '../../include/Defines.php';
require '../../model/ConexaoBD.php';
require '../../model/Read.php';
require '../../model/Lista.php';

//$_SESSION['id'] é o nickname do professor na tabela professor

//Capturando o id [númerico]do professor 'idNum'
$read = new Read();
$read->setDaft('idNum');
$read->ExecutarRead('professor',"where id = '{$_SESSION['id']}'"); //session 'id' é o nickname do professor na tabela professor
try {
    $_SESSION['idNum'] = $read->getResultado()[0]['idNum'];
    //capturando o nome do professor
    $read->setDaft('nome');
    $read->ExecutarRead('professor',"where idNum = '{$_SESSION['idNum']}'");
    $nome = $read->getResultado()[0]['nome'];
} catch (Exception $exc) {
    echo $exc->getTraceAsString();
    die();
}


$lista = new Lista($_SESSION['idNum']);//objeto lista
//capturando os nomes dos cursos do professor
$cursos = $lista->getAllCursos();
        echo "<script>var array = [";
        for($i = 0; $i<count($cursos);$i++){
            echo "'{$cursos[$i]['nome_curso']}',";
        }
        echo "'nada']</script>";
//------------------------------------------



        
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Logado PR html</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/estilo_logadoProfessor.css"/>
        <script src="scripts/script_logadoProfessor.js"></script>
        <!--passando o array php para o js-->
        <script>
            function select(idCurso){
                document.write("<form method='POST' action='InsertCurso.php' id='mular' style='display:none'><input type='text' name='cursoid' value='"+idCurso +"'> </form>");
                document.getElementById('mular').submit();
            }
        </script>
        
    </head>
    <body>
        <div id="area">
            <div id="esquerda"> 
                <h2><?= $nome?></h2>
                <div>
                    <botton onClick="contentDiv()">Meus Cursos</botton>
                    <botton onClick="criarDiv()">Criar Curso</botton>
                </div>
            </div>
            <div id="topo"> 
                <h2 id="title">Meus cursos</h2>
            </div>
            
            <div id="content">
                <!--
                <div class="container" onclick="select(2)">
                    <img src="imgs/271 x 181.png" alt='imagem do curso'>
                    <div class="fade"><a>Curso _ X</a></div>  
                </div>
                -->
              <?php
                
                   for($i = 0; $i<count($cursos); $i++){
                        echo "<div class='container' onclick='select(".$cursos[$i]['id'].")' >
                    <img src='".$cursos[$i]['thumb']."'  alt='Thumb do Curso'> "
                                . "<div class='fade'><a>".$cursos[$i]['nome_curso']."</a></div></div>";
                    }
                    
                ?>
                
                <!-- //Criar Novo curso
                <div class="container" style="opacity: 0.5">
                    <img src="imgs/plus.png" style='width: 35%; margin: 40px 85px;'  alt='imagem do curso'>
                    <div class="fade"><a>Criar Curso</a></div>
                </div> -->
            </div>
            
            <div id="criar">
                <form action="InsertCurso.php" method="GET" id="form">
                    Nome do curso:<br>
                    <input type="text" name="nome" placeholder="Nome do Curso" id="nomeCurso"required><br>
                    
                    
                    <!--verificação de igualdade de nomes de cursos-->
                    <script>
                        nomeCurso =document.getElementById('nomeCurso');
                        nomeCurso.onblur = function(){
                        nome = nomeCurso.value;
                        for (var i = 0; i < array.length; i++) {
                               if ((nome.toUpperCase()) === (array[i].toUpperCase())) {
                                   alert('Esse nome de curso já foi criado, escolha outro cuzaum');
                                   nomeCurso.value = "";
                                   nomeCurso.focus();
                                }
                        }
                    };
                    </script>
                    <!--------------------------------------------------->
                    
                    Preço:<br>
                    R$<input type="number" name="preco" placeholder="ex: R$50" required><br>
                    Descrição:<br>
                    <textarea name="desc" form="form" placeholder="sobre o que é esse curso?" required></textarea><br>
                    <input type="submit" value="Criar Curso" >
                </form>
            </div>
        </div>
    </body>
</html>
