<?php
session_start();

if (!isset($_SESSION['logado']) or !$_SESSION['logado']) { //verificação de logado e se é aluno
    header("location:../view/attention.html?11");
    die();
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

$video =$_GET['v']; //capurando video
$nome = $_GET['a'];//capurando video


//campturando o id do professor
$r->setDaft('id_professor');
$r->ExecutarRead('curso',"where id = {$_SESSION['id_curso']}");
$_idprofessor = $r->getResultado();

//capturando os comentários
$r->setDaft('c.id,texto,nome,sobrenome,nome_aula');
$r->ExecutarRead('comentario',"c join aluno a on c.id_aluno = a.idNum join aula l on l.id = c.id_aula where id_professor = '{$_idprofessor[0]['id_professor']}' and id_aula = '{$_GET['i']}'order by id desc");



$coments = $r->getResultado();
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Video - nect.us</title>
        <link rel="stylesheet" href="estilo_video.css"> 
        <script>
            function turn(num){
                document.getElementById('resp'+num).style.display ='block';
                document.getElementById('rep'+num).style.display ='none';
                
            }
        </script>
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
                <a href="../../view/sobreNos.html" class="topheader">SOBRE NÓS</a>
                <a href="../../view/faleCon.html" class="topheader">FALE CONOSCO</a>
                <a href="../../view/pergFeq.html" class="topheader">PERGUNTAS FREQUENTES</a>
                <div class="dropdown">
                    <img class="bt-drop" style="max-width: 18px" src="../SQL/../view/imagens/t.png">
                    <div class="c-dropdown">
                        <a href="minhaConta.php" class="d">MINHA CONTA</a>
                        <a href="sair.php" class="d">SAIR</a>
                    </div>
                </div>
            </div>        
        </header>
        
        <iframe 
       src="https://www.youtube.com/embed/<?=$video;?>"
       frameborder="1"></iframe>
        <h1><?=$nome?></h1>
        
        <div id="comentarios">
        
        <?php 
        if ($_SESSION['aluno']) {
            
        
        ?>
            <form method="POST" action="insertComent.php">
                <input type="text" placeholder="Insira seu comentário aqui" name="coment" id="comentAluno" required>
                <input type="hidden" name="id_aula" value="<?=$_GET['i']?>">
                <input type="hidden" name="prof" value="<?=$_idprofessor[0]['id_professor']?>">
                <input type="submit" id="enviaA">
            </form>
            <?php
        }//
           //     for($i = 0; $i<count($coments);$i++){
             //       echo "<div class='coment'>"
               //     . "<span class='autor'>".$coments[$i]['nome']." ". $coments[$i]['sobrenome'].":</span><br><span class='com'>".$coments[$i]['texto']."</span><br>"
                 //           . "<form method='post' action='insertSub.php' class='resp' id='resp".$coments[$i]['id']."'>"
                   //         . "<input type='hidden' name='comentid' value='".$coments[$i]['id']."'>"
                     //       . "<input type='text' name='resposta' placeholdrequired><input type='hidden' name='autor' value='".$coments[$i]['nome']." ".$coments[$i]['sobrenome']."'><input type='submit'></form><button id='rep".$coments[$i]['id']."'onclick='turn(".$coments[$i]['id'].")'>Responder<button/></div>";
               // }
            ?>
            <!--listagem dos comentarios-->
                
                <?php
                for($i = 0; $i<count($coments);$i++){
                    echo "<div class='coment'>"
                    . "<span class='autor'>"."<b>".$coments[$i]['nome']." ". $coments[$i]['sobrenome'].":</b> </span>"
                            . "<br>"
                            . "<span class='com'>".$coments[$i]['texto']."</span>"
                            . "<br>"
                            . "<form method='post' action='insertSub.php' class='resp' id='resp".$coments[$i]['id']."'>"
                            . "<input type='hidden' name='comentid' value='".$coments[$i]['id']."'>"
                            . "<input type='hidden' name='autor' value='".$_SESSION['id']."'>"
                            . "<input type='text' name='resposta' placeholder='Resposta' required>"
                            . "<input type='submit'>"
                            . "</form>"
                            . "<button id='rep'".$coments[$i]['id']."'onclick='turn(".$coments[$i]['id'].")'>Responder</button>";
                    
                    $r->setDaft("texto_sub,autor");
                    $r->ExecutarRead('sub_comentario',"where id_comentario = '".$coments[$i]['id']."' order by id desc");
                    $sub = $r->getResultado();
                    for($j = 0;$j< count($sub);$j++){
                        echo "<br><br><span class='sub_rep'> <b>~".$sub[$j]['autor']."~:</b> ".$sub[$j]['texto_sub']."</span>";
                    }
                    echo "</div>";
                }
                
                ?>
        </div>
    </body>
</html>