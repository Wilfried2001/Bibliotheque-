<?php
class Livre {
    private $id;
    private $titre;
    private $nbPages;
    private $image;

    //public static $livres;

    public function __construct($id, $titre, $nbPages, $image) {
        $this->id = $id;
        $this->titre = $titre;
        $this->nbPages = $nbPages;
        $this->image = $image;
        // self::$livres[]= $this; // les crochet pour ajouter a la fin du tableau recuperera le livre qu'on est entrain de créer cad $this
    }
    public function getId() {
        return $this->id;
    }
    public function setId($id){
        $this->id = $id;
    }
    public function getTitre() {
        return $this->titre;
    }
    public function setTitre($titre){
        $this->titre = $titre;
    }
    public function getNbPages() {
        return $this->nbPages;
    }
    public function setNbpages($nbPages) {
        $this->nbPages = $nbPages;
    }
    public function getImage() {
        return $this->image;
    }
    public function setImage($image){
        $this->image = $image;
    }
}