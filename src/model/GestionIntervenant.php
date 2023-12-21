<?php

class GestionIntervenant {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function creerIntervenant($prenom, $nom, $adresseEmail, $motDePasse, $modules) {
        $conn = $this->db->getConnection();
    
        // Échapper les valeurs pour éviter les injections SQL
        $prenom = $conn->real_escape_string($prenom);
        $nom = $conn->real_escape_string($nom);
        $adresseEmail = $conn->real_escape_string($adresseEmail);
    
        // Hasher le mot de passe
        $motDePasseHash = password_hash($motDePasse, PASSWORD_DEFAULT);
    
        // Insérer l'intervenant dans la base de données avec le mot de passe hashé
        $query = "INSERT INTO Intervenant (prenom, nom, adresse_email, mot_de_passe) 
                  VALUES ('$prenom', '$nom', '$adresseEmail', '$motDePasseHash')";
        $result = $conn->query($query);
    
        if ($result) {
            $intervenantID = $conn->insert_id;
    
            // Associer l'intervenant aux modules seulement si des modules ont été sélectionnés
            if (!empty($modules)) {
                foreach ($modules as $moduleID) {
                    $queryAssoc = "INSERT INTO Intervenant_Module (id_intervenant, id_module) VALUES ($intervenantID, $moduleID)";
                    $conn->query($queryAssoc);
                }
            }
    
            return "Intervenant créé avec succès.";
        } else {
            return "Erreur lors de la création de l'intervenant : " . $conn->error;
        }
    }
    
    
    

    public function listeIntervenants() {
        $conn = $this->db->getConnection();
    
        $query = "SELECT Intervenant.id, Intervenant.prenom, Intervenant.nom, Intervenant.adresse_email, Module.nom AS module_nom
                  FROM Intervenant
                  LEFT JOIN Intervenant_Module ON Intervenant.id = Intervenant_Module.id_intervenant
                  LEFT JOIN Module ON Intervenant_Module.id_module = Module.id";
    
        $result = $conn->query($query);
    
        $intervenants = array();
    
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $intervenantId = $row['id'];
                
                // If the intervenant already exists in the array, add the module to its modules array
                if (array_key_exists($intervenantId, $intervenants)) {
                    $intervenants[$intervenantId]->ajouterModule($row['module_nom']);
                } else {
                    // If the intervenant doesn't exist, create a new Intervenant object with the module
                    $intervenant = new Intervenant(
                        $intervenantId,
                        $row['prenom'],
                        $row['nom'],
                        $row['adresse_email'],
                        "", // Empty string for the password (you may need to modify the Intervenant class constructor)
                        [$row['module_nom']] // Array with the first module
                    );
    
                    $intervenants[$intervenantId] = $intervenant;
                }
            }
        }
    
        return $intervenants;
    }
    
    
    

    public function supprimerIntervenant($intervenantID) {
    $conn = $this->db->getConnection();

    // Supprimer les associations avec les modules dans intervenant_module
    $querySupprimerAssociations = "DELETE FROM intervenant_module WHERE id_intervenant = $intervenantID";
    $conn->query($querySupprimerAssociations);

    // Supprimer l'intervenant
    $querySupprimerIntervenant = "DELETE FROM intervenant WHERE id = $intervenantID";
    $result = $conn->query($querySupprimerIntervenant);

    if ($result) {
        return "Intervenant supprimé avec succès.";
    } else {
        return "Erreur lors de la suppression de l'intervenant : " . $conn->error;
    }
}


    public function getIntervenantByAdresseEmail($adresseEmail) {
        $conn = $this->db->getConnection();

        // Échapper la valeur pour éviter les injections SQL
        $adresseEmail = $conn->real_escape_string($adresseEmail);

        // Requête SQL pour récupérer l'intervenant par son adresse email
        $query = "SELECT * FROM Intervenant WHERE adresse_email = '$adresseEmail'";
        $result = $conn->query($query);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Convertir la chaîne JSON des modules en un tableau
            $modules = json_decode($row['modules']);

            $intervenant = new Intervenant(
                $row['id'],
                $row['prenom'],
                $row['nom'],
                $row['adresse_email'],
                $row['mot_de_passe'],
                $modules
            );

            return $intervenant;
        } else {
            return null; // Aucun intervenant trouvé avec cette adresse email
        }
    }
}

?>
