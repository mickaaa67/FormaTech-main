<?php require_once ('src/header.php'); 

$db = new Database();
$gestionModule = new GestionModule($db);

// Vérifier si l'ID du module est spécifié dans l'URL
if (isset($_GET['module_id']) && is_numeric($_GET['module_id'])) {
    $moduleID = intval($_GET['module_id']);
    $module = $gestionModule->getModuleById($moduleID);

    if (!$module) {
        // Rediriger vers la page de gestion-modules.php si le module n'est pas trouvé
        header("Location: gestion-modules.php");
        exit();
    }
} else {
    // Rediriger vers la page de gestion-modules.php si l'ID du module n'est pas spécifié ou n'est pas un entier
    header("Location: gestion-modules.php");
    exit();
}


// Traitement de la modification du module
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modifier_module'])) {
    // Vérifier si les clés sont définies dans le tableau $_POST
    $nouveauNom = isset($_POST['nouveau_nom']) ? $_POST['nouveau_nom'] : '';
    $nouvelleDuree = isset($_POST['nouvelle_duree']) ? (int)$_POST['nouvelle_duree'] : 0;

    // Vérifier si $moduleID est défini
    if ($moduleID) {
        // Appeler la méthode pour modifier le module
        $messageModification = $gestionModule->modifierModule($moduleID, $nouveauNom, $nouvelleDuree);

        // Récupérer les identifiants des formations associées
        $formationsAssociees = isset($_POST['formations_associees']) ? $_POST['formations_associees'] : array();

        // Appeler la méthode pour mettre à jour les formations associées au module
        $messageLierFormations = $gestionModule->lierModuleAFormations($moduleID, $formationsAssociees);
    }
}
?>

    <h1>Modifier le Module</h1>

    <?php
    // Afficher le message de modification (s'il y en a un)
    if (isset($messageModification)) {
        echo "<p>$messageModification</p>";
    }
    ?>

    <!-- Formulaire de modification du module -->
    <form class="formulaire" method="post" action="<?php echo $_SERVER['PHP_SELF'] . '?module_id=' . $moduleID; ?>">
        <label>Nouveau nom du module:</label>
        <input type="text" name="nouveau_nom" value="<?php echo $module->getNom(); ?>" required><br>

        <label>Nouvelle durée (heures):</label>
        <input type="number" name="nouvelle_duree" value="<?php echo $module->getDureeHeures(); ?>" required><br>


        <button type="submit" name="modifier_module">Modifier Module</button>
    </form>
<?php
require_once ('src/footer.php');
?>
