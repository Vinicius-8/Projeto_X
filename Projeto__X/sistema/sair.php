<?php
session_start();
if (!isset($_SESSION['logado'])) {
    header('location:../');
    die();
}
$_SESSION = array();
session_destroy();
header('location:index.php');

