<?php
session_start();
if (!isset($_SESSION['logado']) or !$_SESSION['logado']) { //verificação de logado e se é aluno
    header("location:../view/attention.html?11");
    die();
}else if(!isset($_GET['f'])){
    header("location:minhaConta.php");
}

 
require '../include/Defines.php';
require '../model/ConexaoBD.php';
require '../model/Read.php';

$cond; //variavel de condição
$tabel;//variavel de tabela

$r = new Read();
if ($_SESSION['aluno']) {           //definindo para a consulta do aluno
    $r->setDaft('*');
    $tabel = "inscrito_em";
    $cond = "where id_aluno ='{$_SESSION['idNum']}' and id_curso = '{$_SESSION['id_curso']}'";
} else {                            //definindo para a consulta de professor
    $r->setDaft('nome_curso');
    $tabel = "curso";
    $cond = "where id_professor = '{$_SESSION['idNum']}' and id = '{$_SESSION['id_curso']}'";
}

$r->ExecutarRead($tabel, $cond); //procurando nas tabelas


if (!$r->getResultado()) {
    header("location:../view/attention.html?14");
    die();   
}

$link_form = explode("http", $_GET['f']);
if (count($link_form)<2) {                  //adição do http caso não exista
    $link_form = "http://".$link_form[0];
}else{
    $link_form = $_GET['f'];
}


?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        
        <title>Formulario</title>
        <link href="../view/imagens/logo_tit.png" rel="shortcut icon">
        <link href="estilo_formulario.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        
        <header>        
            <a href="index.php"><div class="logo"> 
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
                <a href="../view/sobreNos.html" class="topheader">SOBRE NÓS</a>
                <a href="../view/faleCon.html" class="topheader">FALE CONOSCO</a>
                <a href="../view/pergFeq.html" class="topheader">PERGUNTAS FREQUENTES</a>
                <div class="dropdown">
                    <img class="bt-drop" style="max-width: 18px" src="../SQL/../view/imagens/t.png">
                    <div class="c-dropdown">
                        <a href="minhaConta.php" class="d">MINHA CONTA</a>
                        <a href="sair.php" class="d">SAIR</a>
                    </div>
                </div>
            </div>        
        </header>
        
        <iframe src="<?=$link_form?>"></iframe>
    </body>
</html>
