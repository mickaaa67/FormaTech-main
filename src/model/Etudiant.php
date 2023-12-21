<?php

class Etudiant {
    private $id;
    private $prenom;
    private $nom;
    private $mail;
    private $dateNaissance;
    private $utilisateur;
    private $mot_de_passe;

    // Constructeur
    public function __construct($id, $prenom, $nom, $mail, $dateNaissance, $utilisateur, $mot_de_passe) {
        $this->id = $id;
        $this->prenom = $prenom;
        $this->nom = $nom;
        $this->mail = $mail;
        $this->dateNaissance = $dateNaissance;
        $this->utilisateur = $utilisateur;
        $this->mot_de_passe = $mot_de_passe;
    }

    // Getters et Setters

    public function getId() {
        return $this->id;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getMail() {
        return $this->mail;
    }

    public function getDateNaissance() {
        return $this->dateNaissance;
    }

    public function getUtilisateur() {
        return $this->utilisateur;
    }

    public function getMotDePasse() {
        return $this->mot_de_passe;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setPrenom($prenom) {
        $this->prenom = $prenom;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function setMail($mail) {
        $this->mail = $mail;
    }

    public function setDateNaissance($dateNaissance) {
        $this->dateNaissance = $dateNaissance;
    }

    public function setUtilisateur($utilisateur) {
        $this->utilisateur = $utilisateur;
    }

    public function setMotDePasse($mot_de_passe) {
        $this->mot_de_passe = $mot_de_passe;
    }

    public static function getById($conn, $id)
    {
        // Préparer la requête SQL pour récupérer les informations de l'étudiant par ID
        $sql = "SELECT * FROM etudiant WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Vérifier si des résultats ont été trouvés
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return new Etudiant(
                $row['id'],
                $row['prenom'],
                $row['nom'],
                $row['mail'],
                $row['dateNaissance'],
                $row['utilisateur'],
                $row['mot_de_passe']
            );
        }

        return null;
    }
     // Méthode pour consulter les promotions de l'étudiant
     public function consulterInformationsPromotions($conn)
    {
        // Préparer la requête SQL pour récupérer les promotions associées à l'étudiant
        $sql = "SELECT id,formation,annee,date_Emargement,date_Fin FROM promotion WHERE idEtudiant = ?";
        $stmt = $conn->prepare($sql);

        // Vérifier les erreurs de préparation
        if (!$stmt) {
            die('Erreur de préparation de la requête: ' . $conn->error);
        }

        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $result = $stmt->get_result();

        $promotions = array();

        // Vérifier si des résultats ont été trouvés
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $promotions[] = new Promotion(
                    $row['id'],
                    $row['formation'],
                    $row['annee'],
                    $row['date_Emargement'],
                    $row['date_Fin'],
                    $this->id,  // Ajoutez l'id de l'étudiant
                    $conn  // Ajoutez la connexion
                );
            }
        }

        return $promotions;
    }



 
     // Méthode pour consulter les sessions à venir de l'étudiant
     public function consulterInformationsSessions($conn)
    {
        // Préparer la requête SQL pour récupérer les sessions à venir de l'étudiant
        $sql = "SELECT * FROM session WHERE idEtudiant = ? AND date_Session >= CURRENT_DATE";
        $stmt = $conn->prepare($sql);

        // Vérifier si la préparation a réussi
        if (!$stmt) {
            die("Erreur de préparation de la requête: " . $conn->error);
        }

        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $result = $stmt->get_result();

        $sessions = array();

        // Vérifier si des résultats ont été trouvés
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $sessions[] = new Session(
                    $row['id'],
                    $row['date_Session'],
                    $row['heure_Debut'],
                    $row['heure_Fin'],
                    $row['nomModule']
                );
            }
        }

        return $sessions;
    }

}
?>
