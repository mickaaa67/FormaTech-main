<?php
include 'src/model/Database.php';
include 'src/model/Promotion.php';

// Créer une instance de la classe Database
$database = new Database();

// Obtenir la connexion à la base de données
$mysqli = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['appliquer'])) {
    $id = $_POST['id'];
    // Assurez-vous de définir les variables $formation, $annee, $dateEmargement, $dateFin
    $formation = $_POST['formation'];
    $annee = $_POST['annee'];
    $dateEmargement = $_POST['date_emargement'];
    $dateFin = $_POST['date_fin'];

    // Récupérer la promotion à modifier
    $promotion = Promotion::getById($mysqli, $id);

    if ($promotion) {
        // Modifier la promotion
        $success = $promotion->modifierPromotion($formation, $annee, $dateEmargement, $dateFin);

        if ($success) {
            // Rediriger vers la page de confirmation des modifications avec l'ID de la promotion
            header("Location: confirmationModification.php?id=$id");
            exit();
        } else {
            // Afficher un message d'erreur
            echo "<p>Une erreur s'est produite lors de la modification de la promotion.</p>";
        }
    } else {
        // Afficher un message d'erreur
        echo "<p>La promotion avec l'ID $id n'a pas été trouvée.</p>";
    }
} else {
    // Rediriger vers une page d'erreur ou afficher un message d'erreur
    echo "<p>Requête invalide.</p>";
}

?>
