<?php
session_start();
define("URL", str_replace("index.php","",(isset($_SERVER["HTTPS"]) ? "https":"http")."://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]"));//Definition d'une constancte URL qui permet d'accéder à toutes les ressources en repartant de la racine du site

require_once "controllers/LivresController.controller.php";
$livrecontroller = new LivresController();
try{
    if(empty($_GET["page"])){
        require "views/accueil.view.php";
    } else {
        $url = explode("/", filter_var($_GET["page"], FILTER_SANITIZE_URL)); // on decompose l'url qu'on mets dans la variable $url(on decompose lapartie page= qui contiendra des elements separé par des /)
        switch ($url[0]) { // on test sur le premier element present dans ûrl
            case "accueil": require "views/accueil.view.php";
            break; 
            case "livres":
                if(empty($url[1])){
                    $livrecontroller->afficherLivres();
                } else if($url[1] =="l"){ // si on demande rien en deuxieme element ca veut dire qu'on affiche tous les livres
                    echo $livrecontroller->afficherUnLivre($url[2]);
                }
                else if($url[1] =="m"){
                    echo $livrecontroller->modificationLivre($url[2]);
                }
                else if($url[1] =="a"){
                    echo $livrecontroller->ajoutLivre();
                }
                else if($url[1] =="av"){
                      $livrecontroller->ajoutLivreValidation();
                }
                else if($url[1] =="mv"){
                    $livrecontroller->modificationLivreValidation();
              }
                else if($url[1] =="s"){
                    echo $livrecontroller->suppressionLivre($url[2]);
                } else {
                    throw new Exception("la page n'existe pas ");
                }
            break;
            default:  throw new Exception("la page n'existe pas ");
        }
    }

}    catch(Exception $e){
    $msg = $e->getMessage();
    require "views/error.view.php";
}

