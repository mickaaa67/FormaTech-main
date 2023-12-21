<?php
session_start();

// Vérifier si l'utilisateur n'est pas connecté
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Rediriger vers la page de connexion
    exit();
}
?>