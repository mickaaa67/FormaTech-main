<?php
    class Promotion {
        private $id;
        private $formation;
        private $annee;
        private $dateEmargement;
        private $dateFin;
        private $idEtudiant;
        private $conn;

        // Constructeur
        public function __construct($id, $formation, $annee, $dateEmargement, $dateFin, $idEtudiant, $conn) {
            $this->id = $id;
            $this->formation = $formation;
            $this->annee = $annee;
            $this->dateEmargement = $dateEmargement;
            $this->dateFin = $dateFin;
            $this->idEtudiant = $idEtudiant;
            $this->conn = $conn;
        }
     
        // Ajout de la méthode setIdEtudiant
        public function setIdEtudiant($idEtudiant) {
            $this->idEtudiant = $idEtudiant;
        }
    
        // Ajout de la méthode getIdEtudiant
        public function getIdEtudiant() {
            return $this->idEtudiant;
        }

        
        // Getter pour l'id
        public function getId(){
            return $this->id;
        }
    
        // Getter pour l'année
        public function getAnnee() {
            return $this->annee;
        }
    
        // Getter pour la date d'émargement
        public function getDateEmargement() {
            return $this->dateEmargement;
        }
    
        // Getter pour la date de fin
        public function getDateFin() {
            return $this->dateFin;
        }

        public function setNombreEtudiants($nombreEtudiants) {
            $this->nombreEtudiants = $nombreEtudiants;
        }
    
        // Ajout de la méthode setFormation
        public function setFormation($formation) {
            $this->formation = $formation;
        }
    
        // Ajout de la méthode getFormation
        public function getFormation() {
            return $this->formation;
        }

        public function getNombreEtudiants() {
            // Préparer la requête SQL
            $sql = "SELECT COUNT(*) as nombreEtudiants FROM etudiant WHERE idPromotion = ?";
    
            // Initialiser le statement à null
            $stmt = null;
    
            try {
                // Préparer la déclaration
                $stmt = $this->conn->prepare($sql);
    
                // Liaison des paramètres
                $stmt->bind_param("i", $this->id);
    
                // Exécuter la requête
                $stmt->execute();
    
                // Récupérer le résultat
                $result = $stmt->get_result();
    
                // Vérifier si des résultats ont été trouvés
                if ($result->num_rows > 0) {
                    // Récupérer la première ligne de résultat
                    $row = $result->fetch_assoc();
    
                    // Retourner le nombre d'étudiants
                    return $row['nombreEtudiants'];
                }
            } finally {
                // Fermer le statement dans tous les cas
                if ($stmt !== null) {
                    $stmt->close();
                }
            }
    
            // En cas d'erreur ou de nombre d'étudiants non trouvé
            return 0;
        }

        public static function getById($conn, $id) {
            $sql = "SELECT * FROM promotion WHERE id = ?";
            $stmt = null;
    
            try {
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();
    
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    return new Promotion(
                        $row['id'],
                        $row['formation'],
                        $row['annee'],
                        $row['date_Emargement'],
                        $row['date_Fin'],
                        $row['idEtudiant'],
                        $conn
                    );
                }
            } finally {
                if ($stmt !== null) {
                    $stmt->close();
                }
            }
    
            return null;
        }
    
        public static function getAll($conn) {
            $result = $conn->query("SELECT * FROM promotion");
            $promotions = [];
    
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $promotions[] = new Promotion(
                        $row['id'],
                        $row['formation'],
                        $row['annee'],
                        $row['date_Emargement'],
                        $row['date_Fin'],
                        $row['idEtudiant'],
                        $conn
                    );
                }
            }
    
            return $promotions;
        }
    
        public function modifierPromotion($formation, $annee, $dateEmargement, $dateFin) {
            $sql = "UPDATE `promotion` SET `formation`=?, `annee`=?, `date_Emargement`=?, `date_Fin`=? WHERE `id`=?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ssssi", $formation, $annee, $dateEmargement, $dateFin, $this->id);
            return $stmt->execute();
        }
    
        public function supprimerPromotion() {
            $sql = "DELETE FROM promotion WHERE id = ? AND formation = ? AND annee = ? AND date_Emargement = ? AND date_Fin = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("issss", $this->id, $this->formation, $this->annee, $this->dateEmargement, $this->dateFin);
            return $stmt->execute();
        }
    }
    
?>
