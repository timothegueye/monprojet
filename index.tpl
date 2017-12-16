<meta http-equiv="cache-control" content="max-age=0" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="expires" content="0" />
<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
<meta http-equiv="pragma" content="no-cache" />

<div class="container">

    
    
    
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
</div>

<!-- Page Content -->
<div class="container">
    <div class="container col-md-6">

    {foreach from=$tab_articles item=$value}
    <div class="card">
        <img class="card-img-top" src="img/{$value['id']}.jpg" alt="">
        <div class="card-body">
            <h4 class="card-title">{$value['titre']} </h4>
            <p class="card-title">{$value['texte']} </p>
            <br>
            {$value['date_fr']}
           <a href="articles.php?action=modifier&id={$value['id']}" class="btn btn-outline-dark" name="Modifier">Modifier</a>
                    <a href="index.php?action=supprimer&id={$value['id']}" class="btn btn-outline-dark" name="Supprimer" onclick="return confirm('Etes vous sûre de vouloir supprimer cet article ?');">Supprimer</a>
                    <a href="index.php?page={$page_courante}&action=commentaire&id={$value['id']}&recherche={$get['recherche']}" class="btn btn-outline-dark" name="commentaire">Commentaire</a>
    </div> 
</div>
    {/foreach}
        
<nav aria-label="Page navigation example">
  <ul class="pagination">
      
            {for $i=1 to $nb_pages}

          <li class="page-item {if $page_courante == $i}active{/if}">
            <a class="page-link" href="?page={$i}">{$i}</a>
                </li>
                {/for}
                
  </ul>
</nav>
    </div>
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
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/popper/popper.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>

