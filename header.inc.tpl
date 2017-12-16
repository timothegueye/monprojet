<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Bare - Start Bootstrap Template</title>
        
        
        

        <!-- Bootstrap core CSS -->
        <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <style>
            body {
                padding-top: 54px;
            }
            @media (min-width: 992px) {
                body {
                    padding-top: 56px;
                }
            }

        </style>

    </head>

    <body>
        

        <!-- Navigation -->
        
        
        <nav class="navbar navbar-expand-lg navbar-dark bg-warning fixed-top">
            <div class="container">                
                <a class="navbar-brand" style="color:white">
                    {if (isset(($nom) AND ($prenom)))}
                        {$nom} {$prenom} est connecté
                {else}Vous êtes actuellement deconnecté{/if}
            </a>
                
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Home
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    
                    
                    
                    

                    {if ($is_connect === TRUE)}
                    
                        <li class="nav-item">
                            <a class="nav-link" href="articles.php">Ajouter un article</a>
                        </li>
                    {else}
                    {/if}
                    {if ($is_connect === TRUE)} 
                        <li class="nav-item">
                            <a class="nav-link" href="inscription.php">Inscription</a>
                        </li>
                    {else}
                    {/if}

                    {if ($is_connect === TRUE)} 
                        <li class="nav-item">
                            <a class="nav-link" href="deconnexion.php">Deconnexion</a>
                        </li>
                    {else}
                        <li class="nav-item">
                            <a class="nav-link" href="connexion.php">Connexion</a>
                            
                        </li>
                    {/if}
                    

                </ul>
            </div>
        </div>
    </nav>
        
