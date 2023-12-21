<?php
include 'src/model/Etudiant.php';
include 'src/model/Promotion.php';
include 'src/model/Session.php';
include 'src/model/Database.php';
require_once ('src/header.php'); 


// Créer une instance de la classe Database
$database = new Database();

// Obtenir la connexion à la base de données
$conn = $database->getConnection();

// Supposons que l'utilisateur soit connecté et que vous ayez son ID
$etudiantId = 1; // Remplacez par l'ID de l'utilisateur connecté

// Récupérer les informations de l'étudiant
$etudiant = Etudiant::getById($conn, $etudiantId);

if ($etudiant) {
    echo "<h2>Informations personnelles</h2>";
    echo "<p>Prénom: " . $etudiant->getPrenom() . "</p>";
    echo "<p>Nom: " . $etudiant->getNom() . "</p>";
    echo "<p>Email: " . $etudiant->getMail() . "</p>";

    // Consulter les promotions de l'étudiant
    $promotions = $etudiant->consulterInformationsPromotions($conn);

    if ($promotions) {
        echo "<h2>Promotions</h2>";
        foreach ($promotions as $promotion) {
            echo "<p>Formation: " . $promotion->getFormation() . "</p>";
            echo "<p>Année: " . $promotion->getAnnee() . "</p>";
            echo "<p>Date d'émargement: " . $promotion->getDateEmargement() . "</p>";
            echo "<p>Date de fin: " . $promotion->getDateFin() . "</p>";
        }
    } else {
        echo "<p>Aucune promotion trouvée.</p>";
    }

    // Consulter les sessions à venir de l'étudiant
    $sessions = $etudiant->consulterInformationsSessions($conn);

    if ($sessions) {
        echo "<h2>Sessions à venir</h2>";
        foreach ($sessions as $session) {
            echo "<p>Date de la session: " . $session->getDateSession() . "</p>";
            echo "<p>Heure de début: " . $session->getHeureDebut() . "</p>";
            echo "<p>Heure de fin: " . $session->getHeureFin() . "</p>";
            echo "<p>Module: " . $session->getNomModule() . "</p>";
        }
    } else {
        echo "<p>Aucune session à venir trouvée.</p>";
    }
} else {
    echo "Étudiant non trouvé.";
}
?>
