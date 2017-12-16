<?php

include ('config/bdd.conf.php');

$is_connect = FALSE;

// vérifie si le cookie "sid" existe et n'est pas vide
if (isset($_COOKIE["sid"]) AND !empty($_COOKIE["sid"])) { 
    //requete pour comparer le sid récupérer à ceux enregistrer dans la base
    $select_sid = "SELECT sid, nom, prenom, id FROM utilisateur WHERE sid = :sid ";
    $sth_sid = $bdd->prepare($select_sid);
    $sth_sid->bindValue(':sid', $_COOKIE["sid"], PDO::PARAM_STR);
    $sth_sid->execute();
    $identite = $sth_sid->fetch(PDO::FETCH_ASSOC);
    //print_r($identite);
    //exit();

        //compte le nombre de ligne 
        $count = $sth_sid->rowCount();
        //echo $count;
        //exit();
		//si le nombre de ligne est supérieur à 0
        if ($count > 0) {
            // on assigne TRUE a la variable de connexion
            $is_connect = TRUE;
            $nom = $identite['nom'];
            $prenom = $identite['prenom'];
            $id_connexion = $identite['id'];
                //echo "Vous etes connecte en tant que .'$nom.' .'$prenom'.";
                //exit();
            
        } else {
            
        }
    } else {
        $notification = "erreur lors de l'execution de la requete";
    } 

?>
