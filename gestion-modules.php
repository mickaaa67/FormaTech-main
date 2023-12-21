<?php require_once ('src/header.php'); 

$db = new Database();
$gestionModule = new GestionModule($db);
$gestionFormation = new GestionFormation($db);

// Traitement de l'ajout d'un module avec formations associées
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ajouter_module'])) {
    $nom = $_POST['nom_module'];
    $dureeHeures = $_POST['duree_heures_module'];
    
    // Appeler la méthode pour ajouter un module
    $formationsAssociees = isset($_POST['formations_associees']) ? $_POST['formations_associees'] : array();
    $moduleID = $gestionModule->ajouterModule($nom, $dureeHeures, $formationsAssociees);
    
    // Récupérer les identifiants des formations associées
    $formationsAssociees = isset($_POST['formations_associees']) ? $_POST['formations_associees'] : array();
    
    // Appeler la méthode pour lier le module aux formations associées
    $messageLierFormations = $gestionModule->lierModuleAFormations($moduleID, $formationsAssociees);
}

// Récupérer la liste des modules
$modules = $gestionModule->listeModules();

// Récupérer la liste des formations pour le formulaire
$formations = $gestionFormation->listeFormations();

// Traitement de la suppression d'un module
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['supprimer_module'])) {
    $moduleID = $_POST['module_id'];
    // Appeler la méthode pour supprimer le module
    $message = $gestionModule->supprimerModule($moduleID);
}

// Traitement du formulaire de modification du module
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modifier_module'])) {
    $moduleID = $_POST['module_id'];
    // Rediriger vers la page de modification avec l'ID du module
    header("Location: modifier-module.php?module_id=" . $moduleID);
    exit();
}

?>


    <h1>Gestion des Modules</h1>

    <?php
    // Afficher le message d'ajout du module et des formations associées (s'il y en a un)
    if (isset($messageAjout)) {
        echo "<p>$messageAjout</p>";
    }

    if (isset($messageLierFormations)) {
        echo "<p>$messageLierFormations</p>";
    }
    ?>

    <!-- Formulaire pour ajouter un module avec formations associées -->
    <form class='formulaire' method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label>Nom du module:</label>
        <input type="text" name="nom_module" required><br>

        <label>Durée (heures):</label>
        <input type="number" name="duree_heures_module" required><br>

        <label>Formations associées:</label>
        <select name="formations_associees[]" multiple>
            <?php foreach ($formations as $formation) : ?>
                <option value="<?php echo $formation->getId(); ?>"><?php echo $formation->getNom(); ?></option>
            <?php endforeach; ?>
        </select><br>

        <button type="submit" name="ajouter_module">Ajouter Module</button>
    </form>

    <h2>Liste des Modules</h2>
        <table class="table">
            <tr>
                <th>Nom</th>
                <th>Durée (heures)</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($modules as $module) : ?>
                <tr>
                    <td><?php echo $module->getNom(); ?></td>
                    <td><?php echo $module->getDureeHeures(); ?></td>
                    <td>
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <input type="hidden" name="module_id" value="<?php echo $module->getId(); ?>">
                            <button type="submit" name="modifier_module">Modifier</button>
                        </form>
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <input type="hidden" name="module_id" value="<?php echo $module->getId(); ?>">
                            <button type="submit" name="supprimer_module">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
<?php
require_once ('src/footer.php');
?>

