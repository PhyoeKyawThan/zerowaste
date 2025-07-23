<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "zwdb";  

// Create connection
$db = mysqli_connect($servername, $username, $password, $dbname); // connecting 

if (!$db) {       
    die("Connection failed: " . mysqli_connect_error());
}

?>