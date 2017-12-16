<?php

function cryptPassword($mdp) {
    $mdp_crypt = sha1($mdp);
    return $mdp_crypt;
}

function sid($email) {
    $sid = md5($email . time());
    return $sid;
}

//fonction de retour index
function pagination($page_courante, $nb_articles_par_page) 
{
    $index = (($page_courante - 1) * $nb_articles_par_page);
    return $index;
}

function nb_total_article_publie($bdd) {
	
	 $sql = "SELECT COUNT(*) as nb_total_article_publie FROM articles WHERE publie = 1";
    
	/* @var $bdd PDO */
	$sth = $bdd->prepare($sql);
    $sth->execute();
    $tab_result = $sth->fetch(PDO::FETCH_ASSOC);
    return $tab_result['nb_total_article_publie'];
}

?>
