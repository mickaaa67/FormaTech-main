<?php

class Module {
    private $id;
    private $nom;
    private $duree;

    // Constructeur
    public function __construct($id, $nom, $duree) {
        $this->id = $id;
        $this->nom = $nom;
        $this->duree = $duree;
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

    public function setId($id) {
        $this->id = $id;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function setDuree($duree) {
        $this->duree = $duree;
    }
}
?>
