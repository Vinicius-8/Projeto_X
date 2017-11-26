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

$read = new Read();
$read->setDaft('idNum');
$read->ExecutarRead('professor',"where id = '{$_SESSION['id']}'");
$_SESSION['idNum'] = $read->getResultado()[0]['idNum'];

$read->setDaft('nome');
$read->ExecutarRead('professor',"where idNum = '{$_SESSION['idNum']}'");


$nome = $read->getResultado()[0]['nome'];

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Logado PR html</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/estilo_logadoProfessor.css"/>
        <script src="scripts/script_logadoProfessor.js"></script>
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
                <div class="container">
                    <img src="imgs/271 x 181.png" alt='imagem do curso'>
                    <div class="fade"><a>Curso _ X</a></div>  
                </div>
                <div class="container">
                    <img src="imgs/assa.PNG" alt='imagem do curso'>
                    <div class="fade"><a>Curso tal</a></div>  
                </div>
                <div class="container">
                    <div class="fade"><a>Curso _ V</a></div>  
                </div>
                
                <!-- //Criar Novo curso
                <div class="container" style="opacity: 0.5">
                    <img src="imgs/plus.png" style='width: 35%; margin: 40px 85px;'  alt='imagem do curso'>
                    <div class="fade"><a>Criar Curso</a></div>
                </div> -->
            </div>
            
            <div id="criar">
                <form action="InsertCurso.php" method="GET" id="form">
                    Nome do curso:<br>
                    <input type="text" name="nome" placeholder="Nome do Curso"required><br>
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
