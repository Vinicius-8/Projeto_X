<?php
//pagina crua
$video = $_GET['v'];//capurando video
$nome = $_GET['a'];//capurando video

?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Video</title>
        <link rel="stylesheet" href="estilo_video.css"> 
    </head>
    <body>
        <header>        
            <a href="index.php"><div class="logo"> 
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
            </div>        
        </header>
        
        <iframe 
       src="https://www.youtube.com/embed/<?=$video;?>"
       frameborder="1"></iframe>
        <h1><?=$nome?></h1>
    </body>
</html>