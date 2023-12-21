<?php
include 'src/model/Database.php';
include 'src/model/Promotion.php';
// CSS
?>
<link rel="stylesheet" href="src/css/base.css">

<?php
// Créer une instance de la classe Database
$database = new Database();

// Obtenir la connexion à la base de données
$mysqli = $database->getConnection();

// Vérifier si un ID de promotion est spécifié dans l'URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Récupérer la promotion modifiée
    $promotion = Promotion::getById($mysqli, $id);

    if ($promotion) {
        // Afficher le récapitulatif des changements
        ?>
        <h2>Récapitulatif des changements :</h2>
        <h4>Formation: <?php echo $promotion->getFormation(); ?></h4>
        <h4>Année: <?php echo $promotion->getAnnee(); ?></h4>
        <h4>Date d'émargement: <?php echo $promotion->getDateEmargement(); ?></h4>
        <h4>Date de fin: <?php echo $promotion->getDateFin(); ?></h4>

        <!-- Ajouter un bouton pour revenir à la vue des promotions -->
        <form method="get" action="vuePromotion.php" style="position: absolute; top: 10px; right: 40px;">
            <input type="submit" value="Retour à la liste des promotions" class="action-btn">
        </form>
        
        <?php
    } else {
        echo "La promotion avec l'ID $id n'a pas été trouvée.";
    }
} else {
    echo "ID de promotion non spécifié.";
}
?>
