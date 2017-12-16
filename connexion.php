<?php
/* @var $bdd PDO */
session_start();
require_once('config/bdd.conf.php');
require_once('config/init.conf.php');
include('include/header.inc.php');
require_once('include/function.inc.php');
require_once('config/connexion.inc.php');


if (isset($_POST['submit'])) {
    print_r($_POST);

    $notification = "Erreur dans l'insertion";
    $_SESSION['inscription_result'] = FALSE;

    if (!empty($_POST['email']) AND !empty($_POST['password'])) {
        // mdp haché 
        $mdp_hash = cryptPassword($_POST['password']);

        // requete + sécurisation des variables
        $select_user = "SELECT email, mdp FROM utilisateur WHERE email = :email AND mdp = :password";
        $sth = $bdd->prepare($select_user);
        $sth->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
        $sth->bindValue(':password', $mdp_hash, PDO::PARAM_STR);
        if ($sth->execute() == TRUE) {
            $count = $sth->rowCount();
            if ($count > 0) {
                $sid = sid($_POST['email']);
                //préparation requête d'update du sid
                $update_sid = "UPDATE utilisateur SET sid= :sid WHERE email = :email";
                $sth_update = $bdd->prepare($update_sid);
                $sth_update->bindValue(':sid', $sid, PDO::PARAM_STR);
                $sth_update->bindValue(':email', $_POST['email'], PDO::PARAM_STR);

                // execution de la reqeête d'update
                if ($sth_update->execute() == TRUE) {
                    //création du cookie
                    setcookie('sid', $sid, time() + 86400);
                    $notification = "Félicitation vous êtes connecté";

                    $_SESSION['notification_connexion'] = $notification;
                    $_SESSION['connexion_result'] = TRUE;
                    header("Location: index.php");
                    exit();
                }
            } else {
                $notification = "Login ou mdp invalide";
                $_SESSION['connexion_result'] = FALSE;
            }
        } else {
            $notification = "Erreur technique survenue";
            $_SESSION['connexion_result'] = FALSE;
        }
    } else {
        $notification = "veuillez renseigner tout les champs";
        $_SESSION['connexion_result'] = FALSE;
    }


    $_SESSION['notification_connexion'] = $notification;
    header('Location:connexion.php');
    exit();
} else {
    ?>
    <div class="container">       
        <?php
        require_once('include/notification.inc.php')
        ?>
    </div>


   
    <div class="container">
        <div class="container col-md-6">
            <h1 class="mt-5">Veuillez vous connecter </h1>
            <form action="connexion.php" method="POST" id="form_connexion">  
			
			
			
			
                <div class="form-group">                  
                    <label for="email" class="col-form-label" color="red" >Email</label>
                    <input type="email" class="form-control" id="nom" name="email" placeholder="exemple@mail.com" required >
					<small class="form-text text-muted">Example : abcd@zyx.com</small>
                </div>
                <div class="form-group">
                    <label for="password" class="col-form-label">Mot de passe</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe" required>
					<small class="form-text text-muted">Au moins caractere speciaux et une majuscule.</small>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary" name="submit">valider</button>    
                </div>
            </form>
        </div>



        <!-- Bootstrap core JavaScript -->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/popper/popper.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="js/dist/jquery.validate.min.js"></script>
        <script src="js/dist/localization/messages_fr.min.js"></script>

        

        <?php
        include ('include/footer.inc.php');
    }
    ?>