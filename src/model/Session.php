<?php

class Session {
    private $id;
    private $date_Session;
    private $heure_Debut;
    private $heure_Fin;
    private $nomModule;

    // Constructeur
    public function __construct($id, $date_Session, $heure_Debut, $heure_Fin, $nomModule) {
        $this->id = $id;
        $this->date_Session = $date_Session;
        $this->heure_Debut = $heure_Debut;
        $this->heure_Fin = $heure_Fin;
        $this->nomModule = $nomModule;
    }

    // Getters et Setters

    public function getId() {
        return $this->id;
    }

    public function getDateSession() {
        return $this->date_Session;
    }

    public function getHeureDebut() {
        return $this->heure_Debut;
    }

    public function getHeureFin() {
        return $this->heure_Fin;
    }

    public function getNomModule() {
        return $this->nomModule;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setDateSession($date_Session) {
        $this->date_Session = $date_Session;
    }

    public function setHeureDebut($heure_Debut) {
        $this->heure_Debut = $heure_Debut;
    }

    public function setHeureFin($heure_Fin) {
        $this->heure_Fin = $heure_Fin;
    }

    public function setNomModule($nomModule) {
        $this->nomModule = $nomModule;
    }
}
?>
