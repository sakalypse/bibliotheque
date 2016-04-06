<?php
//mysql -u klimache -h serveurmysql -p BDD_klimache
// ## accés au modéle
include("connexion_bdd.php");
$ma_requete_SQL ="SELECT OEUVRE.idOeuvre,OEUVRE.titre, OEUVRE.dateParution, AUTEUR.nomAuteur FROM OEUVRE JOIN AUTEUR ON OEUVRE.auteur_id = AUTEUR.idAuteur ORDER BY OEUVRE.idOeuvre";
$reponse =  $ma_connexion_mysql->query($ma_requete_SQL);
$donnees = $reponse->fetchAll();
// ## test
//echo "<pre>"; print_r($donnees); echo "</pre>";

// ## affichage de la vue
?>
<?php include("v_head.php");?>
<?php include("v_nav.php");?>
    <div class="row">
        <table>
            <caption>Recapitulatifs des livres</caption>
            <thead>
            <tr><th>id</th><th>titre</th><th>date de parution</th><th>auteur</th>
            </tr>
            </thead>
            <tbody>
            <?php if(isset($donnees[0])): ?>
                <?php foreach ($donnees as $value): ?>
                    <tr><td>
                            <?php echo($value['idOeuvre']); ?>
                        </td><td>
                            <?= $value['titre']  ?>
                        </td><td>
                            <?= $value['dateParution'] ?>
                        </td><td>
                            <?= $value['nomAuteur'] ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            <tbody>
        </table>
    </div>
<?php include("v_foot.php");?>