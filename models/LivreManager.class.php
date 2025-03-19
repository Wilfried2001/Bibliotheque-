<?php
require_once "Model.class.php";
require_once "Livre.Class.php";

class LivreManager extends Model {
    private $livres; // tableau de livre

    public function ajoutlivre($livre){ /* ici c'est un objet de type livre qui est passé en paramètre de fonction*/
        $this->livres[] = $livre; // on ajoute a la fin du tableau le livre passé en paramètre  // LA FONCTION ajoutLivre prends en parametre un livre et l'ajoute dans l'attribut $livres qui est un tableau
    }
    public function getLivres(){ // cette fonction permet de recuperer tous les livres
        return $this->livres;
    }
    public function chargementLivres(){
        $req = $this->getBdd()->prepare("SELECT * FROM livres"); // ici on recupère la connexion a la BD et on prepare la requete(prepare())
        $req->execute(); // ici on execute la requete
        $meslivres = $req->fetchAll(PDO::FETCH_ASSOC); // ici $meslivres contient 4 valeurs parce que la bd a 4 valeurs(livres) et qui sont stockés sous forme de tableau et qui sont recuperé de la BD grace a fetchAll
        $req->closeCursor(); // closeCursor() permet de fermer la requete

        foreach($meslivres as $mes){ // ici on parcoure la variable $meslivres pour generer tous les livres en utilisant la class Livre(livre.php)
            $l = new Livre($mes["id"],$mes["titre"],$mes["nbPages"],$mes["image"]); // on appel le constructeur de Livre(livre.php) pour generer un livre grace aux informations recupérées de la bd et qui sont stockées dans la variable $meslivres
            $this->ajoutlivre($l); // permet de remplir le tableau de livre present dans livreManager.php qui sera utilié dans livre.php et pour faire cela on utilise la function ajoutLivre et qui prends en parametre un objet(livre)
        
        }
    }
    public function getLivreById($id){
        for($i = 0; $i < count($this->livres); $i++){
            if($this->livres[$i]->getId() == $id){ // ici on compare l'identifiant du livre qu'on est entrain de parcourir avec l'identifiant transfére en parametre de fonction 
                return $this->livres[$i]; // on retourne le livre qui a été trouvé
            }
        }
        throw new Exception("Le livre n'existe pas");

    }
    public function ajoutLivreBd($titre, $nbPages, $image){
        $req = "
        INSERT INTO livres(titre, nbPages, image)
        values(:titre, :nbPages, :image)";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":titre", $titre, PDO::PARAM_STR);
        $stmt->bindValue(":nbPages", $nbPages, PDO::PARAM_INT);
        $stmt->bindValue(":image", $image, PDO::PARAM_STR);
        $resultat = $stmt->execute();
        $stmt->closeCursor();

        if($resultat > 0 ){
            $livre = new Livre($this->getBdd()->lastInsertId(), $titre, $nbPages, $image);
            $this->ajoutlivre($livre);
        }


    }
    public function suppressionLivreBd($id){
        $req = "
        Delete from livres where id = :idLivre
        ";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue("idLivre", $id, PDO::PARAM_INT);
        $resultat = $stmt->execute();
        $stmt->closeCursor();
        if( $resultat > 0){
            $livre = $this->getLivreById($id);
            unset($livre);
        }
    }
    public function modificationLivreBd($id, $titre, $nbPages, $image){
        $req = "
        update livres
        set titre = :titre, nbPages = :nbPages, image = :image
        where id = :id ";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->bindValue(":titre", $titre, PDO::PARAM_STR);
        $stmt->bindValue(":nbPages", $nbPages, PDO::PARAM_INT);
        $stmt->bindValue(":image", $image, PDO::PARAM_STR);
        $resultat = $stmt->execute();
        $stmt->closeCursor();

        if( $resultat > 0){
            $this->getLivreById($id)->setTitre($titre);
            $this->getLivreById($id)->setTitre($nbPages);
            $this->getLivreById($id)->setTitre($image);
        }
    }
} 