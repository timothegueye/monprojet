<div class="container">
    <div class="container col-md-6">

        <div class="alert alert-{$connexion_result} alert-dismissible fade show col-md-6" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>
                {$_SESSION['notification_connexion']};
            </strong>
        </div>
    </div>



    <div class="container">
        <div class="container col-md-6">
            <h1 class="mt-5">Connexion </h1>
            <form action="connexion.php" method="POST">  
                <div class="form-group">
                    <label for="email" class="col-form-label">email</label>
                    <input type="email" class="form-control" id="nom" name="email" placeholder="exemple@mail.com">
                </div>
                <div class="form-group">
                    <label for="password" class="col-form-label">Mot de passe</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe">
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
