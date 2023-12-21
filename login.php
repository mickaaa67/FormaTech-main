<?php require_once ('src/header.php'); 

$db = new Database();
$gestionEmploye = new GestionEmploye($db);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $adresseEmail = $_POST['adresse_email'];
    $motDePasse = $_POST['mot_de_passe'];

    // Récupérer l'employé par son adresse email
    $employe = $gestionEmploye->getEmployeByAdresseEmail($adresseEmail);

    if ($employe && $employe->verifierMotDePasse($motDePasse)) {
        // Authentification réussie, enregistrez l'ID de l'employé en session
        $_SESSION['id_employe'] = $employe->getId();
        header("Location: gestion_formations.php");
        exit();
    } else {
        $messageErreur = "Adresse email ou mot de passe incorrect.";
    }
}
?>

    <h1>Connexion employés</h1>

    <?php
    // Afficher un message d'erreur s'il y a lieu
    if (isset($messageErreur)) {
        echo "<p>$messageErreur</p>";
    }
    ?>

    <!-- Formulaire de connexion -->
    <form class="formulaire" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label>Adresse Email:</label>
        <input type="text" name="adresse_email" required><br>

        <label>Mot de Passe:</label>
        <input type="password" name="mot_de_passe" required><br>

        <button type="submit" name="login">Se Connecter</button>
    </form>
<?php
require_once ('src/footer.php');
?>

