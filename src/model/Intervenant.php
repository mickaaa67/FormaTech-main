<?php

class Intervenant {
    private $id;
    private $prenom;
    private $nom;
    private $mail;
    private $ensembleModule;
    private $utilisateur;
    private $mot_de_passe;

    // Constructeur
    public function __construct($id, $prenom, $nom, $mail, $ensembleModule, $utilisateur, $mot_de_passe) {
        $this->id = $id;
        $this->prenom = $prenom;
        $this->nom = $nom;
        $this->mail = $mail;
        $this->ensembleModule = $ensembleModule;
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

    public function getEnsembleModule() {
        return $this->ensembleModule;
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

    public function setEnsembleModule($ensembleModule) {
        $this->ensembleModule = $ensembleModule;
    }

    public function setUtilisateur($utilisateur) {
        $this->utilisateur = $utilisateur;
    }

    public function setMotDePasse($mot_de_passe) {
        $this->mot_de_passe = $mot_de_passe;
    }
}
?>
