<?php

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
            echo "<script>window.location.href = '../view/attention.html?7';</script>";
        }else{
            //falha
            echo "<script>window.location.href = '../view/attention.html?2';</script>";
 
        }
    } elseif( !empty ($capturaBanco_prof) ) {
        
        if ($senha_login == $capturaBanco_prof[0]['senha']) {
            //sucesso
            echo "<script>window.location.href = '../view/attention.html?8';</script>";
        }else{
            //falha
            echo "<script>window.location.href = '../view/attention.html?2';</script>";
        }
    }else{
        //vazio
        echo "<script>window.location.href = '../view/attention.html?2';</script>";   
    }
}else{
    
        echo "<script>window.location.href = '../view/attention.html?6';</script>";
    }
