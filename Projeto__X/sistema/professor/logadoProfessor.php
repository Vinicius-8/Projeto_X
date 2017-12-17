<?php
session_start();
if (!isset($_SESSION['logado']) or !isset($_SESSION['aluno'])){//verificação de existencia de variavel
    header("location:../../index.html");
    die();
}else if (!$_SESSION['logado'] or $_SESSION['aluno']) {          //verificando se é professor e se está mesmo logado
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

$read->setDaft('idNum');    //idNum é o tipo de informação que quero capturar

$read->ExecutarRead('professor',"where id = '{$_SESSION['id']}'"); //session 'id' é o nickname do professor na tabela professor

try {
    $_SESSION['idNum'] = $read->getResultado()[0]['idNum']; //armazenando o id do professor na variavel de sessao
    
    //capturando o nome do professor
    $read->setDaft('nome');     //tipo de informação que quero capturar
    
    $read->ExecutarRead('professor',"where idNum = '{$_SESSION['idNum']}'");    //tabela onde quero capturar essa info.
    
    $nome = $read->getResultado()[0]['nome']; //armazenando a informação capturada
    
} catch (Exception $exc) {
    echo $exc->getTraceAsString();
    die();
}

//----listagem dos cursos--------
$lista = new Lista($_SESSION['idNum'],true);//objeto lista
//capturando os nomes dos cursos do professor
$cursos = $lista->getAllCursos();   //armazenando todos os cursos capturados
        
        echo "<script>var array = [";
        for($i = 0; $i<count($cursos);$i++){             //transposição de vetor de nomes de cursos do php para o js, afim de evitar cursos com msm nome
            echo "'{$cursos[$i]['nome_curso']}',";
        }
        echo "'nada']</script>";
//------------------------------------------



        
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title><?= $nome?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/estilo_logadoProfessor.css"/>
        <script src="scripts/script_logadoProfessor.js"></script>
        
        <script>
            function select(idCurso){       //metodo que abre o curso correspondente ao clicado, enviando atraves de um formulario os dados necessarios
                document.write("<form method='POST' action='InsertCurso.php' id='mular' style='display:none'><input type='text' name='cursoid' value='"+idCurso +"'> </form>");
                document.getElementById('mular').submit();  //submit do formulario
            }
        </script>
        
    </head>
    <body>
        <header>        
            <a href="../../index.html"><div class="logo"> 
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
                <a href="../../view/sobreNos.html" class="topheader">SOBRE NÓS</a>
                <a href="../../view/faleCon.html" class="topheader">FALE CONOSCO</a>
                <a href="../../view/pergFeq.html" class="topheader">PERGUNTAS FREQUENTES</a>
                <div class="dropdown">
                    <img class="bt-drop" style="max-width: 18px" src="../../view/imagens/t.png">
                    <div class="c-dropdown">
                        <a href="#" class="d">MINHA CONTA</a>
                        <a href="#" class="d">SAIR</a>
                    </div>
                </div>
            </div>        
        </header>
        
        <div id="area">
            
            <div id="esquerda"> 
                <img src="../../view/imagens/user-teacher.png">
                <h2><?= $nome?></h2>
                <div>
                    <botton onClick="contentDiv()">Meus Cursos</botton>
                    <botton onClick="criarDiv()">Criar Curso</botton>
                </div>
            </div>
            
            <div id="topo"> 
                <div class="tit-h2"><h2 id="title">Meus cursos</h2></div>
                
                <div class="sair"><h3><a href="#">SAIR</a><h3></div>

            </div>
            
            <div id="content">
               
              <?php     //listagem de todos os cursos de um determinado professor, que incluem thumb, nome e id
                
                   for($i = 0; $i<count($cursos); $i++){
                        echo "<div class='container' onclick='select(".$cursos[$i]['id'].")' >
                    <img src='".$cursos[$i]['thumb']."'  alt='Thumb do Curso'> "
                                . "<div class='fade'><a>".$cursos[$i]['nome_curso']."</a></div></div>";
                    }
                    
                ?>
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
                                   alert('Esse nome de curso já foi criado');
                                   nomeCurso.value = "";
                                   nomeCurso.focus();
                                }
                        }
                    };
                    </script>
                    
                 
                    Preço:<br>
                     R$<input type="number" name="preco" placeholder="Ex.: R$50" required><br><br>
                    Descrição:<br>
                    <textarea name="desc" form="form" placeholder="Descreva as características do curso" required></textarea><br>
                    <input type="submit" value="Criar Curso" >
                </form>
            </div>
        </div>        
    </body>
</html>
