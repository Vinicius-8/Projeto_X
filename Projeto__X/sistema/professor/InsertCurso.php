<?php
session_start();
if (!$_SESSION['logado'] and $_SESSION['aluno']) {
    echo "<script>alert('Professor nao logado')</script>";
    header("location:../../view/login.html");
    die();
}else if (!isset($_GET)) {
    header('location:index.html');
    die();
}
require '../../include/Defines.php';
require '../../model/ConexaoBD.php';
require '../../model/Create.php';
require '../../model/Read.php';

$nome = (string)$_GET['nome'];
$preco = (double) $_GET['preco'];
$desc = (string) $_GET['desc'];
//inserindo o curso no banco de dados
$create = new Create();
$dados = array('nome_curso'=>$nome,'preco'=>$preco,'descricao'=>$desc,'id_professor'=>$_SESSION['idNum'],'numero_aulas'=>0,'numero_form'=>0,'quant_alunos'=>0);
$create->ExecutarCreate('projeto_x.curso',$dados);

//lendo os cursos do professor
$read = new Read();
$read->setDaft('id');
$read->ExecutarRead('curso', "where id_professor = {$_SESSION['idNum']} and nome_curso = '{$nome}'"); 
$_SESSION['id_curso'] = $read->getResultado()[0]['id'];
header('location:Playlist.php');
exit;