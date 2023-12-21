<?php require_once ('src/header.php'); 

$db = new Database();
$gestionFormation = new GestionFormation($db);

if (isset($_GET['id_formation'])) {
    $formationID = $_GET['id_formation'];
    $formation = $gestionFormation->getFormationById($formationID);

    if ($formation) {
        // Traitement de la modification d'une formation
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modifier_formation'])) {
            // Récupérer les données du formulaire
            $nom = $_POST['nom_formation'];
            $duree = $_POST['duree_formation'];
            $abreviation = $_POST['abreviation_formation'];
            $niveau_rncp = $_POST['niveau_rncp_formation'];
            $statut = $_POST['statut_formation'];

            // Appeler la méthode pour modifier la formation
            $message = $gestionFormation->modifierFormation($formationID, $nom, $duree, $abreviation, $niveau_rncp, $statut);
        }
    } else {
        // Redirection si la formation n'est pas trouvée
        header("Location: gestion_formations.php");
        exit();
    }
} else {
    // Redirection si l'identifiant de la formation n'est pas spécifié
    header("Location: gestion_formations.php");
    exit();
}

?>
    <h1>Détails de la Formation</h1>

    <?php
    // Afficher le message de modification de la formation (s'il y en a un)
    if (isset($message)) {
        echo "<p>$message</p>";
    }
    ?>

    <!-- Formulaire pour modifier la formation -->
    <form class="formulaire" method="post" action="<?php echo $_SERVER['PHP_SELF'] . "?id_formation=$formationID"; ?>">
        <label>Nom de la formation:</label>
        <input type="text" name="nom_formation" value="<?php echo $formation->getNom(); ?>" required><br>

        <label>Durée (en mois):</label>
        <input type="number" name="duree_formation" value="<?php echo $formation->getDuree(); ?>" required><br>

        <label>Abréviation:</label>
        <input type="text" name="abreviation_formation" value="<?php echo $formation->getAbreviation(); ?>" required><br>

        <label>Niveau RNCP:</label>
        <input type="number" name="niveau_rncp_formation" value="<?php echo $formation->getNiveauRncp(); ?>" required><br>

        <label>Statut:</label>
        <select name="statut_formation" required>
            <option value="public" <?php echo ($formation->getStatut() == 'public') ? 'selected' : ''; ?>>Public</option>
            <option value="prive" <?php echo ($formation->getStatut() == 'prive') ? 'selected' : ''; ?>>Privé</option>
        </select><br>

        <button type="submit" name="modifier_formation">Modifier Formation</button>
    </form>

    <!-- Informations supplémentaires sur la formation (par exemple, liste des modules) -->
    <h2>Liste des Modules</h2>
    <?php
    // Récupérer les modules liés à la formation
    $gestionModule = new GestionModule($db);
    $modules = $gestionModule->listeModulesPourFormation($formationID);

    // Afficher la liste des modules
    echo "<ul>";
    foreach ($modules as $module) {
        echo "<li>{$module->getNom()} ({$module->getDureeHeures()} heures)</li>";
    }
    echo "</ul>";
    ?>
<?php
require_once ('src/footer.php');
?>
