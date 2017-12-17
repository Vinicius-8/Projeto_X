<?php
session_start();
if (!isset($_SESSION['logado'])) {
    header('location:../');
    die();
}
session_destroy();
header('location:index.php');

