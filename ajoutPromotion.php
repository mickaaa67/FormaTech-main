<?php

include 'src/model/Database.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $formation = $_POST['formation'];
    $annee = $_POST['annee'];
    $dateEmargement = $_POST['dateEmargement'];
    $dateFin = $_POST['dateFin'];

    // Valider les données (ajoutez vos propres validations si nécessaire)

    // Créer une instance de la classe Database
    $database = new Database();
    $conn = $database->getConnection();

    // Préparer la requête SQL
    $sql = "INSERT INTO promotion (formation, annee, date_Emargement, date_Fin) VALUES (?, ?, ?, ?)";

    // Préparer la déclaration
    $stmt = $conn->prepare($sql);

    // Liaison des paramètres
    $stmt->bind_param("ssss", $formation, $annee, $dateEmargement, $dateFin);

    // Exécution de la requête
    if ($stmt->execute()) {
        $message = "Vous avez ajouté la promotion avec les informations suivantes:<br>
                    Formation: $formation<br>
                    Année: $annee<br>
                    Date d'émargement: $dateEmargement<br>
                    Date de fin: $dateFin";
    } else {
        $message = "Erreur lors de l'ajout de la promotion : " . $stmt->error;
    }

    // Fermer la déclaration et la connexion
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/css/base.css">
    <title>Ajout Promotion</title>
</head>

<body>

    <h2>Ajout d'une Promotion</h2>

    <?php if ($message) : ?>
        <p><?php echo $message; ?></p>
        <form action="ajoutPromotion.php" method="get">
            <input type="submit" value="Ajout d'une autre promotion">
        </form>
        <form method="get" action="vuePromotion.php" style="position: absolute; top: 10px; right: 40px;">
            <input type="submit" value="Retour à la liste des promotions" class="action-btn">
        </form>
    <?php else : ?>
        <form method="post" action="">
            <label for="formation">Formation:</label>
            <input type="text" name="formation" required><br>

            <label for="annee">Année:</label>
            <input type="text" name="annee" required><br>

            <label for="dateEmargement">Date d'émargement:</label>
            <input type="text" name="dateEmargement" placeholder="JJ/MM/AAAA" required><br>

            <label for="dateFin">Date de fin:</label>
            <input type="text" name="dateFin" placeholder="JJ/MM/AAAA" required><br>

            <input type="submit" value="Ajouter">
        </form>
    <?php endif; ?>

</body>

</html>
