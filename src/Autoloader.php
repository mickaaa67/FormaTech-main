<?php
class Autoloader
{
    /**
     * Méthode permettant de charger l'autoload
     */
    public static function register()
    {
        spl_autoload_register(['Autoloader','autoload']); 
        // Note : on peut aussi remplacer "Autoloader" par __CLASS__ pour récupérer le nom de la classe dans laquelle nous nous trouvons.
    }

    /**
     * Méthode permettant de chercher les classes dans le répertoire concerné
     */
    public static function autoload($nom_classe){
        require "model/".$nom_classe.'.php';
    }   
}