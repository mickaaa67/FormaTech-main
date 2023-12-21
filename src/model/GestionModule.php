<?php
class GestionModule {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function ajouterModule($nom, $dureeHeures, $formations) {
        $conn = $this->db->getConnection();
    
        // Logique d'ajout d'un module dans la base de données
        $query = "INSERT INTO Module (nom, duree_heures) VALUES ('$nom', $dureeHeures)";
        $result = $conn->query($query);
    
        if ($result) {
            $moduleID = $conn->insert_id;
    
            // Associer le module aux formations
            foreach ($formations as $formationID) {
                $queryAssoc = "INSERT INTO Formation_Module (id_formation, id_module) VALUES ($formationID, $moduleID)";
                $conn->query($queryAssoc);
            }
    
            return $moduleID; // Retourne l'identifiant du module ajouté
        } else {
            return "Erreur lors de l'ajout du module : " . $conn->error;
        }
    }
    

    public function listeModules() {
        $conn = $this->db->getConnection();
        $query = "SELECT * FROM Module";
        $result = $conn->query($query);
    
        $modules = array();
    
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $module = new Module(
                    $row['id'],
                    $row['nom'],
                    $row['duree_heures']
                );
    
                $modules[] = $module;
            }
        }
    
        return $modules;
    }

    public function listeModulesPourFormation($formationID) {
        $conn = $this->db->getConnection();

        $query = "SELECT Module.id, Module.nom, Module.duree_heures 
                  FROM Module 
                  JOIN Formation_Module ON Module.id = Formation_Module.id_module 
                  WHERE Formation_Module.id_formation = $formationID";

        $result = $conn->query($query);

        $modules = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $module = new Module(
                    $row['id'],
                    $row['nom'],
                    $row['duree_heures']
                );

                $modules[] = $module;
            }
        }

        return $modules;
    }

    public function supprimerModule($moduleID) {
        $conn = $this->db->getConnection();

        // Supprimer les associations avec les formations
        $querySupprimerAssociations = "DELETE FROM Formation_Module WHERE id_module = $moduleID";
        $conn->query($querySupprimerAssociations);

        // Supprimer le module
        $querySupprimerModule = "DELETE FROM Module WHERE id = $moduleID";
        $result = $conn->query($querySupprimerModule);

        if ($result) {
            return "Module et ses associations avec les formations supprimés avec succès.";
        } else {
            return "Erreur lors de la suppression du module : " . $conn->error;
        }
    }

    public function lierModuleAFormations($moduleID, $formationsIDs) {
        $conn = $this->db->getConnection();

        // Supprimer les anciennes associations
        $querySupprimerAssociations = "DELETE FROM formation_module WHERE id_module = $moduleID";
        $conn->query($querySupprimerAssociations);

        // Créer de nouvelles associations
        foreach ($formationsIDs as $formationID) {
            $queryInsererAssociation = "INSERT INTO formation_module (id_formation, id_module) VALUES ($formationID, $moduleID)";
            $conn->query($queryInsererAssociation);
        }

        return "Associations avec les formations mises à jour avec succès.";
    }

    public function getModuleById($moduleID) {
        $conn = $this->db->getConnection();

        $query = "SELECT * FROM Module WHERE id = $moduleID";
        $result = $conn->query($query);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $module = new Module(
                $row['id'],
                $row['nom'],
                $row['duree_heures']
            );

            return $module;
        } else {
            return null; // Ajustez la gestion du cas où le module n'est pas trouvé
        }
    }

    public function modifierModule($moduleID, $nouveauNom, $nouvelleDuree) {
        $conn = $this->db->getConnection();

        // Échapper les valeurs pour éviter les injections SQL
        $nouveauNom = $conn->real_escape_string($nouveauNom);
        $nouvelleDuree = (int)$nouvelleDuree;

        // Mettre à jour le module dans la base de données
        $query = "UPDATE Module SET nom = '$nouveauNom', duree_heures = $nouvelleDuree WHERE id = $moduleID";
        $result = $conn->query($query);

        if ($result) {
            return "Module modifié avec succès.";
        } else {
            return "Erreur lors de la modification du module : " . $conn->error;
        }
    }


    
}
?>
