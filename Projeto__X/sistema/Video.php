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
        <iframe 
       src="https://www.youtube.com/embed/<?=$video;?>"
       frameborder="1"></iframe>
        <h1><?=$nome?></h1>
    </body>
</html>