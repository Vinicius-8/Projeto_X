<?php

define('HOST', 'localhost');
define('USUARIO', 'root');
define('SENHA', '');
define('BANCO', 'projeto_x');

function __autoload($class) {
    if (file_exists("../model/".$class.".php")) {
        require '../model/'.$class.".php";
    }else{
        exit("Erro ao incluir o arquivo model/".$class.".php<hr>");
    }
}
