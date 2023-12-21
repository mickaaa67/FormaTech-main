<?php require_once ('src/header.php'); 

$db = new Database();
$gestionIntervenant = new GestionIntervenant($db);
$gestionModule = new GestionModule($db);

// Traitement de la création d'un intervenant
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['creer_intervenant'])) {
    // Vérifier si les clés sont définies dans le tableau $_POST
    $prenom = isset($_POST['prenom']) ? $_POST['prenom'] : '';
    $nom = isset($_POST['nom']) ? $_POST['nom'] : '';
    $adresseEmail = isset($_POST['adresse_email']) ? $_POST['adresse_email'] : '';
    $motDePasse = isset($_POST['mot_de_passe']) ? $_POST['mot_de_passe'] : '';
    $modules = isset($_POST['modules']) ? $_POST['modules'] : array();

    // Appeler la méthode pour créer un intervenant
    $messageCreation = $gestionIntervenant->creerIntervenant($prenom, $nom, $adresseEmail, $motDePasse, $modules);
}

// Traitement de la suppression d'un intervenant
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['supprimer_intervenant'])) {
    // Vérifier si l'ID de l'intervenant à supprimer est défini dans le tableau $_POST
    $idIntervenant = isset($_POST['id_intervenant']) ? $_POST['id_intervenant'] : '';

    // Appeler la méthode pour supprimer l'intervenant
    $messageSuppression = $gestionIntervenant->supprimerIntervenant($idIntervenant);

    // Afficher le message de suppression
    echo "<p>$messageSuppression</p>";
}

// Récupérer la liste des modules depuis la base de données
$listeModules = $gestionModule->listeModules();

?>

    <h1>Créer un Intervenant</h1>

    <?php
    // Afficher le message de création (s'il y en a un)
    if (isset($messageCreation)) {
        echo "<p>$messageCreation</p>";
    }
    ?>
<!-- Formulaire pour ajouter un intervenant avec les modules associés -->
    <form class='formulaire' method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="prenom">Prénom:</label>
        <input type="text" name="prenom" required><br>

        <label for="nom">Nom:</label>
        <input type="text" name="nom" required><br>

        <label for="adresse_email">Adresse Email:</label>
        <input type="email" name="adresse_email" required><br>

        <label for="mot_de_passe">Mot de passe:</label>
        <input type="password" name="mot_de_passe" required><br>

        <label>Modules associés:</label>
        <table class="module-table">
            <?php foreach ($listeModules as $module) : ?>
                <tr>
                    <td>
                        <input type="checkbox" name="modules[]" value="<?php echo $module->getId(); ?>">
                    </td>
                    <td>
                        <?php echo $module->getNom(); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <button type="submit" name="creer_intervenant">Créer Intervenant</button>
    </form>

    <!-- Liste des intervenants -->
    <h2>Liste des Intervenants</h2>
    <table border="1">
        <tr>
            <th>Prénom</th>
            <th>Nom</th>
            <th>Adresse Email</th>
            <th>Modules</th>
            <th>Action</th>
        </tr>
        <?php
        // Appeler la méthode pour obtenir la liste des intervenants
        $listeIntervenants = $gestionIntervenant->listeIntervenants();

        // Afficher les intervenants dans le tableau
        foreach ($listeIntervenants as $intervenant) {
            echo "<tr>
                    <td>{$intervenant->getPrenom()}</td>
                    <td>{$intervenant->getNom()}</td>
                    <td>{$intervenant->getAdresseEmail()}</td>
                    <td class='module-list'>"; // Début de la liste

                    foreach ($intervenant->getModules() as $module) {
                        echo "$module<br>"; // Utilisation de <br> pour les sauts de ligne
                    }
                    echo "</td>

                    <td>
                        <form method='post' action='{$_SERVER['PHP_SELF']}'>
                            <input type='hidden' name='id_intervenant' value='{$intervenant->getId()}'>
                            <button type='submit' name='supprimer_intervenant'>Supprimer</button>
                        </form>
                    </td>
                </tr>";
        }
        ?>
    </table>
    <?php
    require_once ('src/footer.php');
    ?>
