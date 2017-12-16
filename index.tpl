<head>
    <link rel="stylesheet" href="css/style.css" />
</head>

<div class="container"> 
    
    {if (isset($_SESSION['notification_connexion']))}
    
    <div class="alert alert-{$connexion_result} alert-dismissible fade show col-md-6" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>
            {$_SESSION['notification_connexion']}
        </strong>
    </div>
    {/if}
    
    <!--    espace entre header et barre de recherche-->
    <br>
    
    <!--     barre de recherche-->
    
    <div class="row justify-content-center">
        <div class="col-sm-5">
            <div class="form-group">
                <div class="input-group">
                    <form class="form-inline my-2 my-lg-0 " method="GET" action="index.php">
                        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="recherche">
                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-inverse right-rounded">Recherche</button>
                        </div>
                        </div> 
                </div>
            </div>
            
            {if !isset($smarty.get.recherche)} 
            {foreach from=$tab_articles item=$value}
            <div class="row justify-content-center ">
                <div class="card border border-secondary col-md-6" >
                    <img class="card-img-top" src="img/{$value['id']}.png" alt="">
                    <div class="card-body">
                        <h4 class="card-title">{$value['titre']} </h4>
                        <p class="card-title">{$value['texte']} </p>
                        <br>
                        <h4>Publié le {$value['date_fr']}</h4>
                        {if 
                        $is_connect === TRUE}
                        
                        <a href="articles.php?action=modifier&id={$value['id']}" class="btn btn-outline-dark" name="Modifier">Modifier</a>
                        <a href="index.php?action=supprimer&id={$value['id']}" class="btn btn-outline-dark" name="Supprimer" onclick="return confirm('Etes vous sûre de vouloir supprimer cette valeur ?');">Supprimer</a>
                        </br>
                    
                {if ($get['action']=="commentaire")}
                {foreach from=$tab_articles_commentaire item=$value}
                    <div class="card" style="background-color:#E6E7E6">
                        <div class="card-body">
                            <h6 class="card-title font-weight-bold">Publié par <font color="DarkCyan">{$value['nom']} {$value['prenom']}</font> le {$value['date']} :</h6>
                            <p class="card-text">{$value['txt']}</p>
                        </div>
                    </div>
                    <br>
                </div>
            </div> 
        </div>
        {/foreach}
        {else}
        {foreach from=$tab_articles_recherche item=$value}
        
        <div class="container col-md-6">
            <div class="card">
                <img class="card-img-top" src="img/{$value['id']}.png" alt="">
                <div class="card-body">
                    <h3 class="card-title">{$value['titre']} </h3>
                    <p class="card-title">{$value['texte']} </p>
                    <br>
                    {$value['date_fr']}
                    <br>
                    <br>
                    
                    <a href="articles.php?action=modifier&id={$value['id']}" class="btn btn-outline-dark" name="Modifier">Modifier</a>
                    <a href="index.php?action=supprimer&id={$value['id']}" class="btn btn-outline-dark" name="Supprimer" onclick="return confirm('Etes vous sûre de vouloir supprimer cet article ?');">Supprimer</a>
                    <a href="index.php?page={$page_courante}&action=commentaire&id={$value['id']}&recherche={$get['recherche']}" class="btn btn-outline-dark" name="commentaire">Commentaire</a>
                    <br>
                    <br>
                    <br>
                    {if ($get['action']=="commentaire")}
                    {foreach from=$tab_articles_commentaire item=$value}
                    <div class="card" style="background-color:#000000">
                        <div class="card-body">
                            <h6 class="card-title font-weight-bold">Publié par <font color="black">{$value['nom']} {$value['prenom']}</font> le {$value['date']} :</h6>
                            <p class="card-text">{$value['txt']}</p>
                        </div>
                    </div>
                    <br>
                    {/foreach} 
                            
                    
                    <form action="index.php?action=ajouter_commentaire&id={$value['id']}" method="POST" enctype="multipart/form-data" id="form_commentaire">
                        
                        <div class="form-group">
                            <div class="form-group">
                                <label for="nom" class="col-form-label">nom</label>
                                <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom">
                            </div>
                            
                            <div class="form-group">
                                <label for="prenom" class="col-form-label">prenom</label>
                                <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Prenom">
                            </div>
                            
                            <div class="form-group">
                                <label for="email" class="col-form-label">email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="exemple@mail.com">
                            </div>
                            <label for="commentaire" class="col-form-label">Commentaire</label>
                            <textarea type="text" class="form-control" id="commentaire" name="commentaire" required="required" rows="4" ></textarea>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" name="submit" value="ajouter_commentaire">Ajouter</button>
                            </div>
                        </div>
                    </form>
                    {else}
                    {/if}
                </div>
            </div> 
        </div>
        {/foreach}        
        {/if}
        <br>
        
        <!--  pagination-->
        
        <nav aria-label="Page navigation example  ">
            <ul class="pagination   ">
                        
                
                {for $i=1 to $nb_pages}
                <li class="page-item  {if $page_courante == $i}active{/if}  ">
                    <a class="page-link  " href="?page={$i}   ">{$i}</a>
                </li>
                {/for}
            </ul>
        </nav>
            
    </div>
</div>
        
<!--       Forms ajout de  commentaire-->

<form action="index.php?action=ajouter_commentaire&id={$value['id']}" method="POST" enctype="multipart/form-data" id="form_commentaire">
             
    <a><strong>Ajouter un commentaire</strong></a>
    <div class="form-group">
        <div class="form-group">
            <label for="nom" class="col-form-label">Nom</label><br>
            <input type="text"class="col-sm-10"  id="nom" name="nom" placeholder="Nom" required="required">
        </div>
                            
        <div class="form-group">
            <label for="prenom" class="col-form-label">Prenom</label><br>
            <input type="text" class="col-sm-10"  id="prenom" name="prenom" placeholder="Prenom" required="required">
        </div>
                            
        <div class="form-group">
            <label for="email" class="col-form-label">Email</label><br>
            <input type="email" class="col-sm-10"  id="email" name="email" placeholder="exemple@mail.com" required="required">
        </div>
                        
        <label for="commentaire" class="col-form-label">Commentaire</label><br>
        <textarea type="text" class="col-sm-10"  id="commentaire" name="commentaire" required="required" rows="4" ></textarea>
                            
        <div class="form-group">
            <button type="submit"  name="submit" value="ajouter_commentaire">Ajouter</button
                </div>
                </div>
            </form>
             

<!-- Bootstrap core JavaScript -->
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/popper/popper.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="js/dist/jquery.validate.min.js"></script>
        <script src="js/dist/localization/messages_fr.min.js"></script>
 
  