<!DOCTYPE html>
<html lang="en">
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("../connection/connect.php");
session_start();
// if (empty($_SESSION["adm_id"])) {
//     header('location:index.php');
//     exit();
// }
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar {
            height: 100vh;
            background: #343a40;
            position: fixed;
        }
        .sidebar a {
            color: #fff;
            text-decoration: none;
            display: block;
            padding: 10px;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .dashboard-card i {
            font-size: 2rem;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <?php include 'nav.php' ?>
        <main class="col-md-10 ms-sm-auto col-lg-10 px-md-4 py-4">