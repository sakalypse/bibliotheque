<?php
/**
 * Created by PhpStorm.
 * User: klimache
 * Date: 01/04/16
 * Time: 08:51
 */
function isValidDateTime2($maDate)
{
    $date = DateTime::createFromFormat('dd/mm/Y', $maDate);
    $date_errors = DateTime::getLastErrors();
    if ($date_errors['warning_count'] + $date_errors['error_count'] > 0) {
        $errors = '<br>Message erreur : la date saisie n\'est pas correcte ';
        echo "<br>";
        return false;
    }
    return true ;
}

?>
<?php
include("connexion_bdd.php");

// ## contrôles des données
if(isset($_POST["titre"]) and isset($_POST['date']) and isset($_POST['prenomAuteur']) and isset($_POST['nomAuteur']))
{
    $donnees['titre']=htmlentities($_POST['titre']);
    $donnees['date']=htmlentities($_POST['date']);
    $donnees['prenomAuteur']=htmlentities($_POST['prenomAuteur']);
    $donnees['nomAuteur']=htmlentities($_POST['nomAuteur']);

    $erreurs=array();
    if ((! preg_match("/^[A-Za-z ]{2,}/",$donnees['titre']))) $erreurs['titre']='nom composé de 2 lettres minimum';
    //if ((! isValidDateTime2($donnees['date']))) $erreurs['date']='format jj/mm/aaaa';
    if ((! preg_match("/^[A-Za-z ]{2,}/",$donnees['prenomAuteur']))) $erreurs['prenomAuteur']='nom composé de 2 lettres minimum';
    if ((! preg_match("/^[A-Za-z ]{2,}/",$donnees['nomAuteur']))) $erreurs['nomAuteur']='nom composé de 2 lettres minimum';
    if(empty($erreurs)) {
        // ## accés au modéle
        //on crée l'auteur
        $ma_requete_SQL="INSERT INTO AUTEUR (nomAuteur,prenomAuteur) VALUES (".$donnees['nomAuteur'].",".$donnees['prenomAuteur'].");";
        $ma_connexion_mysql->exec($ma_requete_SQL);

        //on recupere l'id du nouvel auteur généré
        $requete_id_auteur ="SELECT idAuteur FROM AUTEUR WHERE nomAuteur = '".$donnees['nomAuteur']."' AND prenomAuteur = '".$donnees['prenomAuteur']."';";
        $reponse =  $ma_connexion_mysql->query($requete_id_auteur);
        $reponse_id_auteur = $reponse->fetchAll();

        //pour l'utiliser dans la creation de l'oeuvre
        $ma_requete_SQL="INSERT INTO OEUVRE (titre,dateParution, auteur_id) VALUES (".$donnees['titre'].",".$donnees['date'].",".$reponse_id_auteur[idAuteur].");";
        $ma_connexion_mysql->exec($ma_requete_SQL);

        // ## redirection
        header("Location: accueil.php");

    }
}

?>

<?php include("v_head.php");?>
<?php include("v_nav.php");?>
    <form method="POST" action="livre_add.php">
        <div class="row">
            <fieldset>
                <legend>Ajouter un livre</legend>
                <label>Titre
                    <input name="titre"  type="text"  size="18"
                           value="<?php if(isset($donnees['titre'])) echo $donnees['titre']; ?>" />
                    <?php if(isset($erreurs['titre']))    echo '<small class="error">'.$erreurs['titre'].'</small>'; ?>
                </label>

                <label>Date de parution
                    <input name="date"  type="text"  size="18"
                           value="<?php if(isset($donnees['date'])) echo $donnees['date']; ?>" />
                    <?php if(isset($erreurs['date']))    echo '<small class="error">'.$erreurs['date'].'</small>';?>
                </label>

                <label>Prénom auteur
                    <input name="prenomAuteur"  type="text"  size="18"
                           value="<?php if(isset($donnees['prenomAuteur'])) echo $donnees['prenomAuteur']; ?>" />
                    <?php if(isset($erreurs['prenomAuteur']))    echo '<small class="error">'.$erreurs['prenomAuteur'].'</small>'; ?>
                </label>

                <label>Nom auteur
                    <input name="nomAuteur"  type="text"  size="18"
                           value="<?php if(isset($donnees['nomAuteur'])) echo $donnees['nomAuteur']; ?>" />
                    <?php if(isset($erreurs['nomAuteur']))    echo '<small class="error">'.$erreurs['nomAuteur'].'</small>'; ?>
                </label>
                <input type="submit" name="AjouterLivre" value="Ajouter" />

            </fieldset>
        </div>
    </form>
<?php
include("v_foot.php");?>