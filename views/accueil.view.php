<?php ob_start(); ?> 
page d'accueil 
<?php 
$content = ob_get_clean(); // la fonction ob_get_clean permet de deverser se qu'il ya entre les deux balises php
$titre = "Bibliotheque MGA"; // le contenu de la page index.php va utiliser le template template.php
require "template.php";
?>