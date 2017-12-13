<?php
session_start();

if (!$_SESSION['logado'] and !$_SESSION['aluno']) {
    echo "<script>alert('Aluno nao logado')</script>";
    header("location:../view/login.html");
}
    echo "Aluno logado com sucesso<br>";
    echo "ID: ".$_SESSION['id'];

?>
