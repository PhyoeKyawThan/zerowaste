<?php 
session_start();
include 'connection/connect.php';
$title = 'Shop';
include 'parts/start.php'; 
include 'shop/index.php';
include 'parts/end.php'; 
?>