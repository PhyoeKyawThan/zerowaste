<?php
session_start(); 
session_destroy(); 
$url = 'auth/login.php';
header('Location: ' . $url); 

?>