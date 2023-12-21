<?php

session_start();

require_once 'Autoloader.php'; 
Autoloader::register();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/css/base.css">
    <title>Créer un Employé</title>
</head>
<?php include 'menu-employe.php'; ?>
<body>