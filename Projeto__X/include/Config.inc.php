<?php

define('HOST', 'localhost');
define('USUARIO', 'root');
define('SENHA', '');
define('BANCO', 'pdo');

function __autoload($class) {
    if (file_exists("Classes/".$class.".php")) {
        require_once 'Classes/'.$class.".php";
    }else{
        exit("Erro ao incluir o arquivo classes/".$class.".php<hr>");
    }
}
