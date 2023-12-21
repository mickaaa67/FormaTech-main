<?php
class GestionFormation {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function ajouterFormation($nom, $duree, $abreviation, $niveau_rncp, $statut) {
        $conn = $this->db->getConnection();

        // Récupérer l'ID de l'utilisateur depuis la session
        $userId = $_SESSION['id_employe']; 

        // Logique d'ajout d'une formation dans la base de données
        $query = "INSERT INTO Formation (nom, duree, abreviation, niveau_rncp, statut, user_id) VALUES ('$nom', $duree, '$abreviation', $niveau_rncp, '$statut', $userId)";
        $result = $conn->query($query);

        if ($result) {
            return "Formation ajoutée avec succès.";
        } else {
            return "Erreur lors de l'ajout de la formation : " . $conn->error;
        }
    }

    public function listeFormations() {
        $conn = $this->db->getConnection();

        // Récupérer l'ID de l'utilisateur depuis la session
        $userId = $_SESSION['id_employe'];

        $query = "SELECT * FROM Formation WHERE (statut = 'public' OR (statut = 'prive' AND user_id = $userId))";
        $result = $conn->query($query);

        $formations = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $formation = new Formation(
                    $row['id'],
                    $row['nom'],
                    $row['duree'],
                    $row['abreviation'],
                    $row['niveau_rncp'],
                    $row['statut']
                );

                $formations[] = $formation;
            }
        }

        return $formations;
    }

    public function supprimerFormation($formationID) {
        $conn = $this->db->getConnection();

        // Supprimer l'association entre la formation et les modules
        $querySupprimerAssoc = "DELETE FROM Formation_Module WHERE id_formation = $formationID";
        $conn->query($querySupprimerAssoc);

        // Supprimer la formation
        $querySupprimerFormation = "DELETE FROM Formation WHERE id = $formationID";
        $result = $conn->query($querySupprimerFormation);

        if ($result) {
            return "Formation et ses modules associés supprimés avec succès.";
        } else {
            return "Erreur lors de la suppression de la formation : " . $conn->error;
        }
    }

    public function getFormationById($formationID) {
        $conn = $this->db->getConnection();
        $query = "SELECT * FROM Formation WHERE id = $formationID";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $formation = new Formation(
                $row['id'],
                $row['nom'],
                $row['duree'],
                $row['abreviation'],
                $row['niveau_rncp'],
                $row['statut']
            );

            return $formation;
        } else {
            return null; // Formation non trouvée
        }
    }

    public function modifierFormation($formationID, $nom, $duree, $abreviation, $niveau_rncp, $statut) {
        $conn = $this->db->getConnection();

        $query = "UPDATE Formation SET 
                  nom = '$nom',
                  duree = $duree,
                  abreviation = '$abreviation',
                  niveau_rncp = $niveau_rncp,
                  statut = '$statut'
                  WHERE id = $formationID";

        $result = $conn->query($query);

        if ($result) {
            header("Location: ".$_SERVER['PHP_SELF']);
        } else {
            return "Erreur lors de la modification de la formation : " . $conn->error;
        }
    }
}
?>
