<?php
include 'src/model/Database.php';
include 'src/model/Promotion.php';
require_once ('src/header.php'); 

// Créer une instance de la classe Database
$database = new Database();

// Obtenir la connexion à la base de données
$mysqli = $database->getConnection();

// Gestion de la suppression
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['supprimer'])) {
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            // Supprimer la promotion
            $promotion = Promotion::getById($mysqli, $id);
            if ($promotion) {
                $promotion->supprimerPromotion();
                echo "La promotion a été supprimée avec succès.";
            } else {
                echo "La promotion avec l'ID $id n'a pas été trouvée.";
            }
        }
    }

    // Gestion de la modification
    if (isset($_POST['modifier'])) {
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            // Rediriger vers la page de modification
            header("Location: modifierPromotionForm.php?id=$id");
            exit();
        }
    }
}

// Récupérer toutes les promotions après la suppression
$promotions = Promotion::getAll($mysqli);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/css/base.css">
</head>

<body>

    <h2>Liste des Promotions</h2>

     <!-- Formulaire pour le bouton "Ajouter une promotion" -->
    <form method="get" action="ajoutPromotion.php" style="position: absolute; top: 10px; right: 40px;">
        <input type="submit" value="Ajouter une promotion" class="ajouter-btn>">
    </form>

    <?php if (!empty($promotions)) : ?>
        <table>
            <tr>
                <th>Numéro</th>
                <th>Formation</th>
                <th>Année</th>
                <th>Date d'émargement</th>
                <th>Date de fin</th>
                <th>Action</th>
            </tr>

            <?php foreach ($promotions as $promotion) : ?>
                <tr>
                    <td><?php echo $promotion->getId(); ?></td>
                    <td><?php echo $promotion->getFormation(); ?></td>
                    <td><?php echo $promotion->getAnnee(); ?></td>
                    <td><?php echo $promotion->getDateEmargement(); ?></td>
                    <td><?php echo $promotion->getDateFin(); ?></td>
                    <td>
                        <form method="post" action="">
                            <input type="hidden" name="id" value="<?php echo $promotion->getId(); ?>">
                            <input type="submit" name="modifier" value="Modifier">
                        </form>

                        <form method="post" action="">
                            <input type="hidden" name="id" value="<?php echo $promotion->getId(); ?>">
                            <input type="submit" name="supprimer" value="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette promotion ?');">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>

        </table>
    <?php else : ?>
        <p>Aucune promotion disponible.</p>
    <?php endif; ?>

</body>

</html>
