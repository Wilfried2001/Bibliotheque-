<?php

abstract class Model{
    private static $pdo; // on le defini en static pour qu'elle soit accessible par toutes les classes filles et $pdo contiendra l'instance de la connexion a la bd(une seule connexion a la bd)
    // l'attribut static $pdo contiendra l'instance de la connexion a la BD

    private static function setBdd(){ // la fonction static setBdd qui permet créer la connexion a la bd en utilisant les differents parametrages necessaire
        self::$pdo = new PDO("mysql:host=localhost;dbname=biblio;charset=utf8","root","");
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); // la fonction setBdd permet de créer la connexion et de la placer dans l'attribut statique

    }

    protected function getBdd(){ // la fonction getBdd a un role crucial car elle fait deux choses:verifie s'il ya deja une connexion entre le programme et la Bd
        if(self::$pdo === null){
            self::setBdd(); // on appel setBdd a un seul moment au moment de l'appel de la connexion avec la fonction getBdd
            // getBdd se chargera de savoir s'il ya deja une connexion qui existe et c'est elle (getbDD) qui sera utilisée pour faire des requetes pour acceder aux données de la BD
        }
        return self::$pdo;
    }
} 
