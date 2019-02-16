<?php
session_start();
include_once 'db.php';
$logout = $_GET['logout'];
if (isset($_SESSION['login_id']) && $logout = "1"){
    unset($_SESSION['login_id']);
    session_destroy();
    header("Location: ./");
}

?>