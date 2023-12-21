<?php

class Salle {
    private $id;
    private $batiment;
    private $nom;
    private $capacite;

    public function __construct($id, $batiment, $nom, $capacite) {
        $this->id = $id;
        $this->batiment = $batiment;
        $this->nom = $nom;
        $this->capacite = $capacite;
    }

    // Ajoutez les getters et les setters selon vos besoins
    // ...

    public function getId() {
        return $this->id;
    }

    public function getBatiment() {
        return $this->batiment;
    }

    public function setBatiment($batiment) {
        $this->batiment = $batiment;
    }

    public function getNom() {
        return $this->nom;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function getCapacite() {
        return $this->capacite;
    }

    public function setCapacite($capacite) {
        $this->capacite = $capacite;
    }
}

?>
