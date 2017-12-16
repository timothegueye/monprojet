<?php
/* @var $bdd PDO */
session_start();
require_once('include/notification.inc.php');
require_once('config/bdd.conf.php');
require_once('config/init.conf.php');
require_once('config/connexion.inc.php');
require_once('include/function.inc.php');


//recupération de la valeur  dans l'adresse
if (isset($_GET['action']) & !empty($_GET['id'])) {
    $action = $_GET['action'];
    $id = $_GET['id'];
}
else 
{
    
    //sinon on attribue  la valeur ajouter
    $action = "Ajouter";
}

if ($is_connect == TRUE) 
{
    if (isset($_POST['submit'])) {

        
        // print_r($_POST);
        //print_r($_FILES);
        $action = $_POST['submit'];
        if ($_FILES['image']['error'] == 0) {
            $notification = "aucune notification";
            $date_du_jour = date("Y-m-d");
            if (!empty($_POST['titre']) AND !empty($_POST['texte'])) {
                
                // attribution de sa valeur sinon on  met à 0
                $publie = isset($_POST['publie']) ? $_POST['publie'] : 0;
                var_dump($publie);
                
                //echo $_POST['id'];
                //$id = $_POST['id'];
                switch ($action) {
                    case "Ajouter":
                        $requete = "INSERT INTO articles (titre, texte, date, publie) ". "VALUES (:titre, :texte, :date, :publie)";
                        $sth = $bdd->prepare($requete);
                        $sth->bindValue(':titre', $_POST['titre'], PDO::PARAM_STR);
                        $sth->bindValue(':texte', $_POST['texte'], PDO::PARAM_STR);
                        $sth->bindValue(':date', $date_du_jour, PDO::PARAM_STR);
                        $sth->bindValue(':publie', $publie, PDO::PARAM_BOOL);
                        break;
                    
                    case "modifier":

                        $requete = "UPDATE articles SET titre = :titre, texte = :texte, publie = :publie WHERE id = :id";
                        $sth = $bdd->prepare($requete);
                        $sth->bindValue(':titre', $_POST['titre'], PDO::PARAM_STR);
                        $sth->bindValue(':texte', $_POST['texte'], PDO::PARAM_STR);
                        $sth->bindValue(':publie', $publie, PDO::PARAM_BOOL);
                        $sth->bindValue(':id', $id, PDO::PARAM_INT);
                        break;
                        
                        $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                }
                echo $action;
                if ($sth->execute() == TRUE) {
                    $id_article = !empty($_POST['id']) ? $_POST['id'] : $bdd->lastInsertId();
                    
                    //image ajout d'article
                    move_uploaded_file($_FILES['image']['tmp_name'], 'img/' . $id_article . '.' . $extension);
                    
                    //echo $id_article;
                    //print_r($_FILES);
                    //exit();
                    
                    $notification = "Article ajouter";
                    $_SESSION['notification_result'] = TRUE;
                }
                
                // if erreur d'insertion
                
                else {
                    $notification = "erreur dans l'insertion";
                    $_SESSION['notification_result'] = FALSE;
                }
            }
            
            // if (!empty($_POST['titre'])
            
            else {
                $notification = "veuillez renseigner les champs obligatoires..";
                $_SESSION['notification_result'] = FALSE;
            }
        }
        
        //if ($_FILES['image']['error'] == 0)
        
        else {
            $notification = "erreur de traitement de l'image";
            $_SESSION['notification_result'] = FALSE;
        }
        $_SESSION['notification'] = $notification;
        
        header('Location:articles.php');
        exit();
    } 
    else 
    {
        include('include/header.inc.php');
?>

<?php
        if ($action == "modifier") {
            $sql = "SELECT * FROM articles WHERE id = :id";
            
            //echo $sql;
            
            $sth = $bdd->prepare($sql);
            $sth->bindValue(':id', $id, PDO::PARAM_INT);
            $sth->execute();
            if ($sth->execute() === TRUE) {
                $tab_articles_modifier = $sth->fetchAll(PDO::FETCH_ASSOC);
                
                //print_r($tab_articles);
                //echo $tab_articles[0]['titre'];
                //echo $row['texte'];
            }
            else 
            {
                echo "Une erreur est apparu";
            }
            
            foreach ($tab_articles_modifier as $value) {
                $publie = $value['publie'];
                $titre = $value['titre'];
                $texte = $value['texte'];
            }
            
            //echo $publie;
        }
        else 
        {
            $publie = 0;
        }
?>

<link rel="stylesheet" href="css/style.css" />
<div class="container col-md-6">
    <div class="row justify-content-center " >
        <h1 class="mt-4"><?= $action ?> un article </h1>
    </div>
    <br>
    
    <?php
            if (isset($_SESSION['notification'])) {
            $notification_result = $_SESSION['notification_result'] == TRUE ? 'success' : 'danger';?>
                
    <div class="alert alert-<?= $notification_result ?> alert-dismissible fade show col-md-6" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        
        <strong>
            <?php echo $_SESSION['notification'];?>
        </strong>
    </div>
    
    <?php
            unset($_SESSION['notification']);
            unset($_SESSION['notification_result']);
        }
    ?>
    
    <form action="articles.php" method="POST" enctype="multipart/form-data" >            
        <div class="form-group">
            <label for="titre" class="col-form-label">titre</label>                    
            <input type="text" class="form-control" id="titre" name="titre" value="<?= isset($titre) ? $titre : "veuillez indiquer un titre"; ?>"> </div>
        
        <div class="form-group">a
            <label for="texte" class="col-form-label">texte</label>
            <textarea type="text" class="form-control" id="texte" name="texte" rows="6" ><?= isset($texte) ? $texte : "veuillez indiquer un texte"; ?></textarea></div>
        
        <div class="form-group">
            <label class="custom-file">
                <input type="file" id="image" class="custom-file-input" name="image" >
                <span class="custom-file-control"></span></label>
            
            <?php
        if ($action == "modifier") {
            ?>
            <img src="img/<?php echo $value['id'] ?>.png" alt="" width="200px">
            
            <?php
        } 
        else 
        {
        }
            ?></div>
        
        <form class="was-validated">
            <label class="form-check-label">
                <input class="form-check-input" type="checkbox" id="publie" value="1" <?php if ($publie == 1) { ?> checked <?php } ?> name="publie"> Publie
                <input type="hidden" name="id" value="<?= $id ?>" /></label>
            
            <div class="form-group">
                <button type="submit" class="btn btn-primary" name="submit" value="<?= $action ?>"><?= $action ?></button></div>
        </form>
        </div>



    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/popper/popper.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="js/dist/jquery.validate.min.js"></script>
    <?php
                include ('include/footer.inc.php');
    }
} 
else 
{
    header("Location: connexion.php");
}
    ?>