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

include('include/header.inc.php');

$nb_articles_par_page = 2;
$page_courante = isset($_GET['page']) ? $_GET['page'] : 1;
//echo $page_courante;
$index = pagination($page_courante, $nb_articles_par_page);
//echo $index;
//exit();
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
} else {
    echo "Une erreur est apparu";
}
?>
<?php
if (isset($_POST['recherche'])) {
    $recherche = $_POST['recherche'];
    echo $recherche;
    $sql = "SELECT id, titre, texte, DATE_FORMAT(date, '%d/%m/%Y') as date_fr
FROM articles
WHERE (titre LIKE :recherche or texte LIKE :recherche) 
AND publie=1 
ORDER BY date DESC LIMIT :index, :nb_articles_par_page";

    $sth = $bdd->prepare($sql);
    $sth->bindValue(':recherche', '%' . $recherche . '%', PDO::PARAM_STR);
    $sth->bindValue(':index', $index, PDO::PARAM_INT);
    $sth->bindValue(':nb_articles_par_page', $nb_articles_par_page, PDO::PARAM_INT);
    $sth->execute();
    $nb_resultats = $sth->rowCount();
    if ($nb_resultats != 0) {

        foreach ($tab_articles as $value) {
            ?>
            <div class="card">
                <img class="card-img-top" src="img/<?php echo $value['id'] ?>.png" alt="">
                <div class="card-body">
                    <h4 class="card-title"><?php echo $value['titre'] ?> </h4>
                    <p class="card-title"><?php echo $value['texte'] ?> </p>
                    <br>
                    <?php echo $value['date_fr'] ?>
                    <a href="articles.php?action=modifier&id=<?= $value['id'] ?>" class="btn btn-primary" name="modifier">Modifier</a>
                </div> 
            </div>
            <?php
        }
    } else {
        echo "aucun résultat";
    }
} else {
    
}
?>

<div class="container">
    <?php
    require_once('include/notification.inc.php')
    ?>

</div>

<!-- Page Content -->
<div class="container">
    <div class="container col-md-6">
        <?php
        foreach ($tab_articles as $value) {
            ?>
            <div class="card">
                <img class="card-img-top" src="img/<?php echo $value['id'] ?>.png" alt="">
                <div class="card-body">
                    <h4 class="card-title"><?php echo $value['titre'] ?> </h4>
                    <p class="card-title"><?php echo $value['texte'] ?> </p>
                    <br>
                    <?php echo $value['date_fr'] ?>
                    <a href="articles.php?action=modifier&id=<?= $value['id'] ?>" class="btn btn-primary" name="modifier">Modifier</a>
                </div> 
            </div>
            <?php
        }
        ?>

        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <?php
                for ($i = 1; $i <= $nb_pages; $i++) {
                    $is_active = $page_courante == $i ? 'active' : '';
                    ?>
                    <li class="page-item <?= $is_active ?>">
                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                    <?php
                }
                ?>

            </ul>
        </nav>
    </div>
</div>
<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/popper/popper.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<?php
include ('include/footer.inc.php');
?>




