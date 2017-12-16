<?php

/* @var $bdd PDO */
session_start();
require_once('include/notification.inc.php');
require_once('config/bdd.conf.php');
require_once('config/init.conf.php');
require_once('config/connexion.inc.php');
require_once('include/function.inc.php');

//Class smarty
require_once('libs/Smarty.class.php');


$nb_articles_par_page = 2;
$page_courante = isset($_GET['page']) ? $_GET['page'] : 1;

$index = pagination($page_courante, $nb_articles_par_page);
$nb_total_article_publie = nb_total_article_publie($bdd);

//echo $nb_total_article_publie;
$nb_pages = ceil($nb_total_article_publie / $nb_articles_par_page);

//echo $nb_pages;

$sql = "SELECT id, "
        . "titre, "
        . "texte, "
        . "DATE_FORMAT (date, '%d/%m/%Y') as date_fr "
        . "FROM articles "
        . "WHERE publie = :publie "
        . "LIMIT :index , :nb_articles_par_page ; ";
		
//echo $sql;
$sth = $bdd->prepare($sql);
$sth->bindValue(':publie', 1, PDO::PARAM_BOOL);
$sth->bindValue(':index', $index, PDO::PARAM_INT);
$sth->bindValue(':nb_articles_par_page', $nb_articles_par_page, PDO::PARAM_INT);
$sth->execute();
if ($sth->execute() == TRUE) {
    $tab_articles = $sth->fetchAll(PDO::FETCH_ASSOC);
    //print_r($tab_articles);
    //echo $tab_articles[0]['titre'];
    //echo $row['texte'];

} 
else
{
    echo "Une erreur est apparu";
}

// moteur de recherche 

if (isset($_GET['recherche'])) {
    $sql = "SELECT id, "
            . "titre, "
            . "texte, "
            . "DATE_FORMAT(date, '%d/%m/%Y') as date_fr "
            . "FROM articles "
            . "WHERE (titre LIKE :recherche OR texte LIKE :recherche) "
            . "AND publie=1 "
            . "ORDER BY date DESC "
            . "LIMIT :debut, :message_par_page";

    /* @var $bdd PDO */
    $std = $bdd->prepare($sql);
    $std->bindValue(':recherche', '%' . $_GET['recherche'] . '%', PDO::PARAM_STR);
    $std->bindValue(':publie', 1, PDO::PARAM_BOOL);
    $std->bindValue(':debut', $index, PDO::PARAM_INT);
    $std->bindValue(':message_par_page', $nb_articles_par_page, PDO::PARAM_INT);



    if ($std->execute() == TRUE) {
        $tab_articles_recherche = $std->fetchAll(PDO::FETCH_ASSOC);
        
        //print_r($tab_articles_recherche);
    }
    else 
    {
        echo "Une erreur est survenue.. ";
    }
}


$smarty = new Smarty();

$smarty->setTemplateDir('templates/');
$smarty->setCompileDir('templates_c/');
//$smarty->config_dir   = '/web/www.example.com/guestbook/configs/';
//$smarty->cache_dir    = '/web/www.example.com/guestbook/cache/';

$smarty->assign('is_connect', $is_connect);
//$smarty->assign('nom_connect', $nom_connect);
$smarty->assign('session', $_SESSION);
$smarty->assign('nb_pages', $nb_pages);
$smarty->assign('page_courante', $page_courante);
$smarty->assign('tab_articles', $tab_articles);
$smarty->assign('value', $value);
$smarty->assign('tab_articles_recherche', $tab_articles_recherche);

$smarty->assign('get', $_GET);


//$smarty->assign('value', $value);

if ($is_connect == TRUE) {
    if (isset($_GET['action'])) {
        if ($_GET['action'] == "supprimer") {
            $sql = "DELETE FROM articles WHERE id = :id ";     //DELETE FROM contact WHERE id = ".$id
            $std = $bdd->prepare($sql);
            $std->bindValue(':id', $_GET['id'], PDO::PARAM_INT);

            if ($std->execute() == TRUE) {
            
                //header('Location:index.php');
            
            } else {
                echo "Une erreur est survenue.. ";
            }
            //suppression de id_article
            
            $sql_com = "DELETE FROM commentaire WHERE id_article = :id ";     
            $std_com = $bdd->prepare($sql_com);
            $std_com->bindValue(':id', $_GET['id'], PDO::PARAM_INT);

            if ($std_com->execute() == TRUE) {
                header('Location:index.php');
            }
            else 
            {
                echo "Une erreur est survenue.. ";
            }
        }
    }
}

//notification de connection

if (isset($_SESSION['notification_connexion'])) {
    $connexion_result = $_SESSION['connexion_result'] == TRUE ? 'success' : 'danger';
    $smarty->assign('connexion_result', $connexion_result);
    unset($_SESSION['notification_connexion']);
    unset($_SESSION['connexion_result']);
}

if (isset($_GET['action'])) {
    if ($_GET['action'] == "commentaire") {
        $sql = "SELECT commentaire.texte as txt, commentaire.nom, commentaire.prenom, commentaire.date as date "
            . "FROM commentaire "
            . "INNER JOIN articles ON commentaire.id_article=articles.id "
            . "WHERE id_article = :id "
            . "ORDER BY date ASC "
            . "LIMIT 0, 5  ";
        
        $std = $bdd->prepare($sql);
        $std->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
        if ($std->execute() == TRUE) {
            $tab_articles_commentaire = $std->fetchAll(PDO::FETCH_ASSOC);

            //header('Location:articles.php');
            //print_r ($tab_articles_commentaire);7
            
        } 
        else 
        {
            echo "Une erreur est survenue.. ";
        }
    }
}
$smarty->assign('tab_articles_commentaire', $tab_articles_commentaire);
if ($is_connect == TRUE) {
    if (isset($_GET['action'])) {
        if ($_GET['action'] == "ajouter_commentaire") {
            $date_du_jour = date('Y-m-d');
            //echo $date_du_jour; 
            echo $_GET['id'];
            $sql = "INSERT INTO commentaire values ('', :commentaire, :datedujour, :id_articles, :nom, :prenom, :email)";

            $std = $bdd->prepare($sql);
            $std->bindValue(':commentaire', $_POST['commentaire'], PDO::PARAM_STR);
            $std->bindValue(':datedujour', $date_du_jour, PDO::PARAM_STR);
            $std->bindValue(':id_articles', $_GET['id'], PDO::PARAM_INT);
            $std->bindValue(':nom', $_POST['nom'], PDO::PARAM_STR);
            $std->bindValue(':prenom', $_POST['prenom'], PDO::PARAM_STR);
            $std->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
            if ($std->execute() === TRUE) {
                header('Location:index.php');
            } else {
                echo "Une erreur est survenue.. ";
            }
        }
    }
}

//** un-comment the following line to show the debug console
//$smarty->debugging = true;

include('include/header.inc.php');
include ('include/footer.inc.php');
$smarty->display('index.tpl');

?>