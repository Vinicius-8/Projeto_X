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


//capturando os comentários
$read->setDaft('c.id,texto,nome,sobrenome,nome_aula');
$read->ExecutarRead('comentario',"c join aluno a on c.id_aluno = a.idNum join aula l on l.id = c.id_aula where id_professor = '{$_SESSION['idNum']}'order by id desc");
$coments = $read->getResultado();

?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title><?= $nome?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/estilo_logadoProfessor.css"/>
        <script src="scripts/script_logadoProfessor.js"></script>
        <style>
            #forum .coment .resp  {
                display: none;
            }               
        </style>
        <script>
            function select(idCurso){       //metodo que abre o curso correspondente ao clicado, enviando atraves de um formulario os dados necessarios
                document.write("<form method='POST' action='InsertCurso.php' id='mular' style='display:none'><input type='text' name='cursoid' value='"+idCurso +"'> </form>");
                document.getElementById('mular').submit();  //submit do formulario
            }
            function turn(num){
                document.getElementById('resp'+num).style.display ='block';
                document.getElementById('rep'+num).style.display ='none';
                
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
                <img src="../../view/imagens/user_teacher.png">
                <h2><?= $nome?></h2>
                <div>
                    <botton onClick="contentDiv()">Meus Cursos</botton>
                    <botton onClick="criarDiv()">Criar Curso</botton>
                    <botton onClick="forumDiv()">Fórum</botton>
                </div>
            </div>
            
            <div id="topo"> 
                <div class="tit-h2"><h2 id="title">Fórum</h2></div>

            </div>
            
            <div id="content" style="display:none">
               
              <?php     //listagem de todos os cursos de um determinado professor, que incluem thumb, nome e id
                
                   for($i = 0; $i<count($cursos); $i++){
                        echo "<div class='container' onclick='select(".$cursos[$i]['id'].")' >
                    <img src='".$cursos[$i]['thumb']."'  alt='Thumb do Curso'> "
                                . "<div class='fade'><a>".$cursos[$i]['nome_curso']."</a></div></div>";
                        
                    }
                    
                ?>
            </div>
            
            <div id="criar" style="display:none">
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
            <div id="forum">
                <!--listagem dos comentarios-->
                
                <?php
                for($i = 0; $i<count($coments);$i++){
                    echo "<div class='coment'>"
                    . "<span class='autor'>Aula: ".$coments[$i]['nome_aula'].""
                            . "<br>"
                            . "<br>"
                            ."<b>".$coments[$i]['nome']." ". $coments[$i]['sobrenome']."</b>: </span>"
                            . "<br>"
                            . "<span class='com'>".$coments[$i]['texto']."</span>"
                            . "<br>"
                            . "<form method='post' action='../insertSub.php' class='resp' id='resp".$coments[$i]['id']."'>"
                            . "<input type='hidden' name='comentid' value='".$coments[$i]['id']."'>"
                            . "<input type='hidden' name='autor' value='".$_SESSION['id']."'>"
                            . "<input type='text' name='resposta' placeholder='Resposta' required>"
                            . "<input type='submit'>"
                            . "</form>"
                            . "<button id='rep'".$coments[$i]['id']."'onclick='turn(".$coments[$i]['id'].")'>Responder</button>";
                    
                    $read->setDaft("texto_sub,autor");
                    $read->ExecutarRead('sub_comentario',"where id_comentario = '".$coments[$i]['id']."' ");
                    $sub = $read->getResultado();
                    for($j = 0;$j< count($sub);$j++){
                        echo "<br><br><span class='sub_rep'> <b>~".$sub[$j]['autor']."~</b>: ".$sub[$j]['texto_sub']."</span>";
                    }
                    echo "</div>";
                }
                
                ?>

            </div>
            
        </div>        
    </body>
</html>
