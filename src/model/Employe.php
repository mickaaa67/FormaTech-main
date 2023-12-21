<?php

class Employe {
    private $id;
    private $prenom;
    private $nom;
    private $mail;
    private $poste;
    private $utilisateur;
    private $mot_de_passe;

    public function __construct($id, $prenom, $nom, $mail, $poste, $utilisateur, $mot_de_passe) {
        $this->id = $id;
        $this->prenom = $prenom;
        $this->nom = $nom;
        $this->mail = $mail;
        $this->poste = $poste;
        $this->utilisateur = $utilisateur;
        $this->mot_de_passe = $mot_de_passe;
    }

    // Ajoutez les getters et les setters selon vos besoins
    // ...

    public function getId() {
        return $this->id;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function setPrenom($prenom) {
        $this->prenom = $prenom;
    }

    public function getNom() {
        return $this->nom;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function getMail() {
        return $this->mail;
    }

    public function setMail($mail) {
        $this->mail = $mail;
    }

    public function getPoste() {
        return $this->poste;
    }

    public function setPoste($poste) {
        $this->poste = $poste;
    }

    public function getUtilisateur() {
        return $this->utilisateur;
    }

    public function setUtilisateur($utilisateur) {
        $this->utilisateur = $utilisateur;
    }

    public function getMotDePasse() {
        return $this->mot_de_passe;
    }

    public function setMotDePasse($mot_de_passe) {
        $this->mot_de_passe = $mot_de_passe;
    }
}

?>
