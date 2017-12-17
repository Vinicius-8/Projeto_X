<?php
session_start();
if (!isset($_SESSION['logado'])) {
    echo "1";
    header('location:../view/login.html');
}else if($_SESSION['aluno']){
    echo "<script>window.location.href = 'aluno/logadoAluno.php';</script>";
}else{
    echo "<script>window.location.href = 'professor/logadoProfessor.php';</script>";
    die();
}