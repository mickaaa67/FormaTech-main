<?php require_once ('src/header.php'); 

$db = new Database();
$gestionEmploye = new GestionEmploye($db);

// Traitement de la création d'un employé
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['creer_employe'])) {
    // Vérifier si les clés sont définies dans le tableau $_POST
    $prenom = isset($_POST['prenom']) ? $_POST['prenom'] : '';
    $nom = isset($_POST['nom']) ? $_POST['nom'] : '';
    $poste = isset($_POST['poste']) ? $_POST['poste'] : '';
    $adresseEmail = isset($_POST['adresse_email']) ? $_POST['adresse_email'] : '';
    $motDePasse = isset($_POST['mot_de_passe']) ? $_POST['mot_de_passe'] : '';

    // Appeler la méthode pour créer un employé
    $messageCreation = $gestionEmploye->creerEmploye($prenom, $nom, $poste, $adresseEmail, $motDePasse);
}

// Traitement de la suppression d'un employé
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['supprimer_employe'])) {
    // Vérifier si l'ID de l'employé à supprimer est défini dans le tableau $_POST
    $idEmploye = isset($_POST['id_employe']) ? $_POST['id_employe'] : '';

    // Appeler la méthode pour supprimer l'employé
    $messageSuppression = $gestionEmploye->supprimerEmploye($idEmploye);

    // Afficher le message de suppression
    echo "<p>$messageSuppression</p>";
}
?>
    <h1>Créer un Employé</h1>

    <?php
    // Afficher le message de création (s'il y en a un)
    if (isset($messageCreation)) {
        echo "<p>$messageCreation</p>";
    }
    ?>

    <!-- Formulaire de création d'un employé -->
    <form class="formulaire" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label>Prénom:</label>
        <input type="text" name="prenom" required><br>

        <label>Nom:</label>
        <input type="text" name="nom" required><br>

        <label>Poste:</label>
        <input type="text" name="poste" required><br>

        <label>Adresse Email:</label>
        <input type="email" name="adresse_email" required><br>

        <label>Mot de passe:</label>
        <input type="password" name="mot_de_passe" required><br>

        <button type="submit" name="creer_employe">Créer Employé</button>
    </form>

    <!-- Liste des employés -->
<h2>Liste des Employés</h2>
<table border="1">
    <tr>
        <th>Prénom</th>
        <th>Nom</th>
        <th>Poste</th>
        <th>Adresse Email</th>
        <th>Action</th>
    </tr>
    <?php
    // Appeler la méthode pour obtenir la liste des employés
    $listeEmployes = $gestionEmploye->listeEmployes();

    // Afficher les employés dans le tableau
    foreach ($listeEmployes as $employe) {
        echo "<tr>
                <td>{$employe->getPrenom()}</td>
                <td>{$employe->getNom()}</td>
                <td>{$employe->getPoste()}</td>
                <td>{$employe->getAdresseEmail()}</td>
                <td>
                    <form method='post' action='{$_SERVER['PHP_SELF']}'>
                        <input type='hidden' name='id_employe' value='{$employe->getId()}'>
                        <button type='submit' name='supprimer_employe'>Supprimer</button>
                    </form>
                </td>
              </tr>";
    }
    ?>
</table>


<?php
require_once ('src/footer.php');
?>

