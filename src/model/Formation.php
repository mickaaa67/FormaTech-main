<?php

class Formation {
    private $id;
    private $nom;
    private $duree;
    private $abreviation;
    private $niveauRNCP;

    // Constructeur
    public function __construct($id, $nom, $duree, $abreviation, $niveauRNCP) {
        $this->id = $id;
        $this->nom = $nom;
        $this->duree = $duree;
        $this->abreviation = $abreviation;
        $this->niveauRNCP = $niveauRNCP;
    }

    // Getters et Setters

    public function getId() {
        return $this->id;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getDuree() {
        return $this->duree;
    }

    public function getAbreviation() {
        return $this->abreviation;
    }

    public function getNiveauRNCP() {
        return $this->niveauRNCP;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function setDuree($duree) {
        $this->duree = $duree;
    }

    public function setAbreviation($abreviation) {
        $this->abreviation = $abreviation;
    }

    public function setNiveauRNCP($niveauRNCP) {
        $this->niveauRNCP = $niveauRNCP;
    }
}
?>
