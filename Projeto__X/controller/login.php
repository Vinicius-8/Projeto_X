<?php
session_start();

$_SESSION['logado'] = false;    
$_SESSION['id'] = null;
$_SESSION['aluno'] = false;

if (isset($_POST)) {
    require '../include/Config.inc.php';
    
    $id_login =(string) $_POST['id'];
    $senha_login = (string)md5( $_POST['senha']);
    
    $read = new Read();
    
    //tabela de aluno
    $read->ExecutarRead('aluno', "where id = '{$id_login}'");
    $capturaBanco_aluno = $read->getResultado();
    
   if(!$capturaBanco_aluno){
        //tabela de professor
    $read->ExecutarRead('professor', "where id = '{$id_login}'");
    $capturaBanco_prof = $read->getResultado();
   }
    
    
    if (!empty($capturaBanco_aluno)) {
        
        if ($senha_login == $capturaBanco_aluno[0]['senha']) {
            //sucesso
            $_SESSION['logado'] = true;
            $_SESSION['aluno'] = true;
            $_SESSION['id'] = $id_login;
            echo "<script>window.location.href = '../view/attention.html?7';</script>";
        }else{
            //falha
            echo "<script>window.location.href = '../view/attention.html?2';</script>";
 
        }
    } elseif( !empty ($capturaBanco_prof) ) {
        
        if ($senha_login == $capturaBanco_prof[0]['senha']) {
            //sucesso
            $_SESSION['logado'] = true;
            $_SESSION['aluno'] = false;
            $_SESSION['id'] = $id_login;
            echo "<script>window.location.href = '../view/attention.html?8';</script>";
        }else{
            //falha
            echo "<script>window.location.href = '../view/attention.html?2';</script>";
        }
    }else{
        //usuário não cadastrado
        echo "<script>window.location.href = '../view/attention.html?2';</script>";   
    }
    }else{
        //login vazio
        echo "<script>window.location.href = '../view/attention.html?6';</script>";
    }
