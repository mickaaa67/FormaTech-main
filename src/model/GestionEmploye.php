<?php
class GestionEmploye {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function creerEmploye($prenom, $nom, $poste, $adresseEmail, $motDePasse) {
        $conn = $this->db->getConnection();

        // Échapper les valeurs pour éviter les injections SQL
        $prenom = $conn->real_escape_string($prenom);
        $nom = $conn->real_escape_string($nom);
        $poste = $conn->real_escape_string($poste);
        $adresseEmail = $conn->real_escape_string($adresseEmail);

        // Hasher le mot de passe
        $motDePasseHash = password_hash($motDePasse, PASSWORD_DEFAULT);

        // Insérer l'employé dans la base de données avec le mot de passe hashé
        $query = "INSERT INTO Employe (prenom, nom, poste, adresse_email, mot_de_passe) 
                  VALUES ('$prenom', '$nom', '$poste', '$adresseEmail', '$motDePasseHash')";
        $result = $conn->query($query);

        if ($result) {
            return "Employé créé avec succès.";
        } else {
            return "Erreur lors de la création de l'employé : " . $conn->error;
        }
    }

    public function listeEmployes() {
        $conn = $this->db->getConnection();
    
        $query = "SELECT id, prenom, nom, poste, adresse_email, mot_de_passe FROM Employe";
        $result = $conn->query($query);
    
        $employes = array();
    
        while ($row = $result->fetch_assoc()) {
            $employe = new Employe(
                $row['id'],
                $row['prenom'],
                $row['nom'],
                $row['poste'],
                $row['adresse_email'],
                $row['mot_de_passe']
            );
    
            $employes[] = $employe;
        }
    
        return $employes;
    }

    public function supprimerEmploye($idEmploye) {
        $conn = $this->db->getConnection();
    
        // Échapper la valeur pour éviter les injections SQL
        $idEmploye = $conn->real_escape_string($idEmploye);
    
        // Supprimer l'employé de la base de données
        $query = "DELETE FROM Employe WHERE id = '$idEmploye'";
        $result = $conn->query($query);
    
        if ($result) {
            return "Employé supprimé avec succès.";
        } else {
            return "Erreur lors de la suppression de l'employé : " . $conn->error;
        }
    }

    public function getEmployeByAdresseEmail($adresseEmail) {
        $conn = $this->db->getConnection();

        // Échapper la valeur pour éviter les injections SQL
        $adresseEmail = $conn->real_escape_string($adresseEmail);

        // Requête SQL pour récupérer l'employé par son adresse email
        $query = "SELECT id, prenom, nom, poste, adresse_email, mot_de_passe FROM Employe WHERE adresse_email = '$adresseEmail'";
        $result = $conn->query($query);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $id = $row['id'];
            $prenom = $row['prenom'];
            $nom = $row['nom'];
            $poste = $row['poste'];
            $adresseEmail = $row['adresse_email'];
            $motDePasse = $row['mot_de_passe'];

            $employe = new Employe($id, $prenom, $nom, $poste, $adresseEmail, $motDePasse);
            return $employe;
        } else {
            return null; // Aucun employé trouvé avec cette adresse email
        }
    }
  
    
    
    
}
?>
 