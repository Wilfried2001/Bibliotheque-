<?php

require_once "models/LivreManager.class.php";

class LivresController{
    private $livreManager;

    public function __construct(){
        $this->livreManager = new LivreManager(); //$this permet de conserver les informations dans l'attribut $livreManager et de le remplir
        $this->livreManager->chargementLivres(); 
    }
    public function afficherLivres(){
        $livres = $this->livreManager->getLivres(); // on recupère tous les livres que l'on mets dans la variable $livres et qui sera utilisé par la vu "views/livres.view.php"
        require "views/livres.view.php";
    }
    public function afficherUnLivre($id){
        $livre = $this->livreManager->getLivreById($id); // la fonction getLivreById retourne un livre et c'est pour cela qu'on l'a mets dans la variable $livre
        require "views/afficherLivre.view.php";
    }
    public function ajoutLivre(){
        require "views/ajoutLivre.view.php";

    }
    public function ajoutLivreValidation(){
        $file = $_FILES['image'];
        $repertoire = "public/images/";
        $nomImageAjoute = $this->ajoutImage($file,$repertoire);
        $this->livreManager->ajoutLivreBd($_POST['titre'], $_POST['nbPages'],$nomImageAjoute);
        $_SESSION['alert'] = [
            "type" => "success",
            "msg" => "Ajout Réalisé"
        ];
        header('Location: '. URL . "livres");
    }
    public function suppressionLivre($id){
        $monImage = $this->livreManager->getLivreById($id)->getImage();
        unlink("public/images/".$monImage);
        $this->livreManager->suppressionLivreBd($id);
        $_SESSION['alert'] = [
            "type" => "success",
            "msg" => "Suppression Réalisée"
        ];
        header('Location: '. URL . "livres");
    }
    public function modificationLivre($id){
        $livre = $this->livreManager->getLivreById($id);
        require "views/modifierLivre..view.php";

    }
    public function modificationLivreValidation(){
        $imageActuelle = $this->livreManager->getLivreById($_POST['identifiant'])->getImage();
        $file = $_FILES['image'];

        if($file['size'] > 0 ){
            unlink("public/images/".$imageActuelle);
            $repertoire = "public/images/";
            $nomImageToAdd = $this->ajoutImage($file,$repertoire);
        } else{
            $nomImageToAdd = $imageActuelle;
        }
        $this->livreManager->modificationLivreBd($_POST['identifiant'],$_POST['titre'],$_POST['nbPages'], $nomImageToAdd );
        $_SESSION['alert'] = [
            "type" => "success",
            "msg" => "Modification Réalisée"
        ];  
        header('Location: '. URL . "livres");
    }

    private function ajoutImage($file, $dir){
        if(!isset($file['name']) || empty($file['name']))
            throw new Exception("Vous devez indiquer une image");

        if(!file_exists($dir))  mkdir($dir,0777);

        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $random = rand(0,99999);
        $target_file = $dir.$random."_".$file['name'];

        if(!getimagesize($file["tmp_name"]))
            throw new Exception("Le fichier n'est pas une image");

        if($extension !== "jpg" && $extension !== "jpeg" && $extension !== "png" && $extension !=="gif")
            throw new Exception("L'extension du fichier n'est pas reconnu");

        if(file_exists($target_file))
            throw new Exception("Le fichier existe deja");

        if($file["size"] > 500000 )
            throw new Exception("Le fichier est trop volumineux");

        if(!move_uploaded_file($file["tmp_name"], $target_file))
            throw new Exception("L'ajout de l'image n'a pas fonctionné");
        else return ($random."_".$file["name"]);
    }

}

