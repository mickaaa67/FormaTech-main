<?php
include 'src/model/Database.php';
include 'src/model/Promotion.php';

// Créer une instance de la classe Database
$database = new Database();

// Obtenir la connexion à la base de données
$mysqli = $database->getConnection();

// Vérifier si un ID de promotion est spécifié dans l'URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Récupérer la promotion à modifier
    $promotion = Promotion::getById($mysqli, $id);

    if ($promotion) {
        ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="src/css/base.css">
            <title>Modifier la Promotion</title>
        </head>

        <body>

            <h2>Modifier la Promotion</h2>

            <form method="post" action="processModifierPromotion.php">
                <input type="hidden" name="id" value="<?php echo $promotion->getId(); ?>">
                <label for="formation">Formation:</label>
                <input type="text" name="formation" value="<?php echo $promotion->getFormation(); ?>"><br>

                <label for="annee">Année:</label>
                <input type="text" name="annee" value="<?php echo $promotion->getAnnee(); ?>"><br>

                <label for="date_emargement">Date d'émargement:</label>
                <input type="text" name="date_emargement" value="<?php echo $promotion->getDateEmargement(); ?>"><br>

                <label for="date_fin">Date de fin:</label>
                <input type="text" name="date_fin" value="<?php echo $promotion->getDateFin(); ?>"><br>

                <input type="submit" name="appliquer" value="Valider les changements">
            </form>

            <form method="get" action="vuePromotion.php" style="position: absolute; top: 10px; right: 40px;">
                <input type="submit" value="Retour à la liste des promotions" class="action-btn">
            </form>

        </body>

        </html>
        <?php
    } else {
        echo "La promotion avec l'ID $id n'a pas été trouvée.";
    }
} else {
    echo "ID de promotion non spécifié.";
}
?>
