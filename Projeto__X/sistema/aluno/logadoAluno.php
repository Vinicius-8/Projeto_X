<?php
session_start();

if ($_SESSION['logado']) {
    echo "Aluno logado com sucesso<br>";
    echo "ID: ".$_SESSION['id'];
}else{
    echo "<script>alert('Aluno nao logado')</script>";
    header("location:../view/login.html");
}
?>
