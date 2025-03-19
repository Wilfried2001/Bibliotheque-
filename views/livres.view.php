<?php
//require_once "Livre.Class.php"; // permet de recuperer une seule fois 
//$l1 = new Livre(1,"Algo selon H2PROG",300,"algo.png");
//$l2 = new Livre(2,"Le virus informatique",200,"virus.png");
//$l3 = new Livre(3,"La france du 19ème",100,"france.png");
//$l4 = new Livre(4,"LE Javascript client",500,"JS.png");
//$livres = [$l1,$l2, $l3, $l4];

//require_once "LivreManager.class.php";
//$livreManager = new LivreManager(); // génère le livre manager qui est un objet
//$livreManager->ajoutlivre($l1); // remplir le tableau de livre en utilisant la fonction ajoutlivre
//$livreManager->ajoutlivre($l2);
//$livreManager->ajoutlivre($l3);
//$livreManager->ajoutlivre($l4); // les livres sont maintenant disponible dans le tableau $livres present dans l'objet $livremanager

//$livreManager->chargementLivres();


ob_start();
if(!empty($_SESSION['alert'])) :
?>
<div class=" alert alert-<?= $_SESSION['alert']['type'] ?> " role="alert" >
<?= $_SESSION['alert']['msg'] ?>

</div>
<?php 
unset($_SESSION['alert']);
endif; ?>
 
<table class="table text-center">
    <tr class="table-dark">
        <th>Image</th>
        <th>Titre</th>
        <th>Nombre de pages</th>
        <th colspan="2">Actions </th>
    </tr>
    <?php
    for ($i = 0; $i < count($livres); $i++): ?>
    <tr>
        <th class="align-middle"><img src="public/images/<?=$livres[$i]->getImage(); ?>" alt="" width="60px"></th>
        <th class="align-middle"> <a href="<?= URL ?>livres/l/<?= $livres[$i]->getId(); ?>"><?=$livres[$i]->getTitre(); ?></a></th>
        <th class="align-middle"><?=$livres[$i]->getNbPages(); ?></th>
        <th class="align-middle"><a href="<?= URL ?>livres/m/<?= $livres[$i]->getId(); ?> " class="btn btn-warning">Modifier</a> </th>
        <th class="align-middle">
        <form method="POST" action="<?= URL ?>livres/s/<?= $livres[$i]->getId(); ?> " onsubmit="return confirm('Voulez vous vraiment supprimer ce livre ? ');">
                <button class="btn btn-danger" type="submit" >
                    Supprimer
                </button>

            </form>

        </th>
    </tr>
    <?php endfor ?>
</table>
<a href=" <?= URL ?>livres/a " class="btn btn-success d-block">Ajouter</a>
<?php
$content = ob_get_clean(); // la fonction ob_get_clean permet de deverser se qu'il ya entre les deux balises php
$titre = "Les livres de la bibliotheque";
require "template.php";
?> 