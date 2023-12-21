<?php require_once ('src/header.php'); 

$db = new Database();
$gestionFormation = new GestionFormation($db);

// Traitement de la suppression d'une formation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['supprimer_formation'])) {
    $formationID = $_POST['formation_id'];
    // Appeler la méthode pour supprimer la formation et ses associations de modules
    $message = $gestionFormation->supprimerFormation($formationID);
}

// Traitement de l'ajout d'une formation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ajouter_formation'])) {
    // Récupérer les données du formulaire
    $nom = $_POST['nom_formation'];
    $duree = $_POST['duree_formation'];
    $abreviation = $_POST['abreviation_formation'];
    $niveau_rncp = $_POST['niveau_rncp_formation'];
    $statut = $_POST['statut_formation'];

    // Appeler la méthode pour ajouter une formation
    $message = $gestionFormation->ajouterFormation($nom, $duree, $abreviation, $niveau_rncp, $statut);
}

// Récupérer la liste des formations avec les modules
$formations = $gestionFormation->listeFormations();

?>

    <h1>Gestion des Formations</h1>

    <!-- Formulaire pour ajouter une formation -->
    <form class="formulaire" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label>Nom de la formation:</label>
        <input type="text" name="nom_formation" required><br>

        <label>Durée (en mois):</label>
        <input type="number" name="duree_formation" required><br>

        <label>Abréviation:</label>
        <input type="text" name="abreviation_formation" required><br>

        <label>Niveau RNCP:</label>
        <input type="number" name="niveau_rncp_formation" required><br>

        <label>Statut:</label>
        <select name="statut_formation" required>
            <option value="public">Public</option>
            <option value="prive">Privé</option>
        </select><br>

        <button type="submit" name="ajouter_formation">Ajouter Formation</button>
    </form>

    <?php
    // Afficher le message d'ajout ou suppression de la formation (s'il y en a un)
    if (isset($message)) {
        echo "<p>$message</p>";
    }
    ?>

    <!-- Liste des formations -->
<h2>Liste des Formations</h2>
<table border="1">
    <tr>
        <th>Nom</th>
        <th>Abréviation</th>
        <th>Durée (mois)</th>
        <th>Niveau RNCP</th>
        <th>Statut</th>
        <th>Modules</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($formations as $formation) : ?>
        <tr>
            <td><?php echo $formation->getNom(); ?></td>
            <td><?php echo $formation->getAbreviation(); ?></td>
            <td><?php echo $formation->getDuree(); ?></td>
            <td><?php echo $formation->getNiveauRncp(); ?></td>
            <td><?php echo $formation->getStatut(); ?></td>
            <td>
                <?php
                // Récupérer les modules liés à la formation
                $gestionModule = new GestionModule($db);
                $modules = $gestionModule->listeModulesPourFormation($formation->getId());

                // Afficher la liste des modules
                echo "<ul>";
                foreach ($modules as $module) {
                    echo "<li>{$module->getNom()} ({$module->getDureeHeures()} heures)</li>";
                }
                echo "</ul>";
                ?>
            </td>
            <td>
                <a href="details_formation.php?id_formation=<?php echo $formation->getId(); ?>">
                    <button type="button">Détails</button>
                </a>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <input type="hidden" name="formation_id" value="<?php echo $formation->getId(); ?>">
                    <button type="submit" name="supprimer_formation">Supprimer</button>
                </form>
                <!-- Ajoutez d'autres actions au besoin -->
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php
require_once ('src/footer.php');
?>

