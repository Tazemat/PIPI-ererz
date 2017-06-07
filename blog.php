<?php include('include/bdd.php'); ?>
<!DOCTYPE html>
<html>
<head>
  <title>Le rocket league blog mec</title>
  <meta charset="UTF8">
  <link rel="stylesheet" href="blog.css">
  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
  <style>
  <?php if(isset($_GET['theme']) AND $_GET['theme'] == 'sun')
  {
   ?> #header{ background-color: white; } #footer{ background-color: white; } <?php   }  ?>
  </style>
</head>
<body>
  <?php include('include/header.php'); ?>
  <?php include('include/nav.php');  ?>
  <div id="contenu">
    <p>
      <?php
      if(isset($_POST['statut']) AND $_POST['statut'] == 'Rediger' AND ($_SESSION['id'] == 52 OR $_SESSION['id'] == 57) AND isset($_SESSION['login']))
      {
        ?>

        <div class="centrage">
          <div class="rediger">
            <form method="post" action="" >
              <input type="submit" name="statut" value="Annuler">
            </form>
          </div>
        </div>
        <span id="a">
          <a href="https://fr.wikipedia.org/wiki/BBCode">L'outil de rédaction prend en charge le BBCODE</a>
        </span>
        <div id="redaction">
          <form method="post" action="">
            <label for="citation">Rediger citation :
              <input type="text" name="citation" id="citation" placeholder="48 caractere maximum en comptant ceux du pseudo"></label>
              <input type="submit" Value="Poster"><br/>
            </form>
            <form method="post" action="">
              <label for="titre">Titre de l'article :<br/><input type="text"  id="titre" name="titre"></label><br/>
              <label for="Contenu">Contenu de l'article :<br/><textarea   name="contenu" id="Contenu"></textarea></label><br/><br/>
              <input type="submit" name="valider" value="Poster"><br/><br/> <label for="video">Nouvelle vidéo :<input type="text" name="video" id="video" placeholder=" Ici insere les lien de video a afficher sur le site"></label>
              <input type="submit" Value="Poster"><br/><br/><br/><br/><br/><br/>
            </form>
          </div>
          <?php
        } 
        elseif(isset($_GET['articleid']) AND !empty($_GET['articleid']) AND is_numeric($_GET['articleid']))
        {
          ?><div class="centrage">
          <div class="rediger">
            <form method="get" action="" >
              <input type="submit" name="statut" value="Annuler">
            </form>
          </div>
        </div>
        <br/><br/>
        <?php
        $ket=$bdd->prepare('SELECT  id, commentaire, pseudo, DATE_FORMAT(date_commentaire, \'%e/%c/%Y à %k:%i\') AS date_c, idarticle FROM commentaire WHERE idarticle = ? ORDER BY date_commentaire');
        $ket->execute(array($_GET['articleid'])); 
        while($don = $ket->fetch())
          { ?>
        <div class="commentaire">
          <p><?php echo nl2br($don['commentaire']); ?></p>
          <h2>-<a href="ee"><?php echo  $don['pseudo']; ?></a><?php echo'  le '.$don['date_c']; ?></h2>
          <br/>
        </div>
        <?php
      }
      ?>
      <?php  if(isset($_SESSION['login']))
      {
       ?>
       <form method="post" action="">
         <span id="comment">
           <div class="rediger"><div id="z"><textarea id="comment" placeholder="Ecris un commentaire!" name="commentaire"></textarea><input type="submit"></div></div>
         </span>
       </form>
       <?php }
       else{
         ?><span id="pr"><p><a href="http://lessepts.esy.es/login.php">Connecte toi</a> via Les 7 et réagis à l'article !</p></span>
         <?php  }
         ?>

         <?php 
         $po = $bdd->prepare('SELECT id, contenu, titre, pseudo, DATE_FORMAT(date_redaction, \'%e/%c/%Y à %k:%i\') AS date_r FROM test WHERE id = ? ORDER BY id DESC');
         $po->execute(array($_GET['articleid']));
         $donn = $po->fetch();
         ?>
         <div class="articel">
           <h1><?php echo $donn['titre'] ; ?></h1>
           <p><?php echo nl2br($donn['contenu']); ?></p><br/>
           <span><?php echo  '-Ecrit par ' .$donn['pseudo'].'  le '.$donn['date_r']; ?></span>
           <br/><br/>
         </div>

         <?php
       }
       else{
        ?>
      </p>
      <br/>
      <?php if(isset($_SESSION['id']) AND ($_SESSION['id'] == 52 OR $_SESSION['id'] == 57))
      { ?>
      <div class="centrage">
        <form method="post" action="">
          <div class="rediger">
            <input type="submit" name="statut" value="Rediger">
          </div>
        </form>
      </div>
      <?php }  ?>
      <p>
        <?php
        $pi = $bdd->query('SELECT id, contenu, titre, pseudo, DATE_FORMAT(date_redaction, \'%e/%c/%Y à %k:%i\') AS date_r FROM test ORDER BY id DESC');
        while($donne = $pi->fetch())
        {
         ?>
         <div class="articel">
           <h1><?php echo $donne['titre'] ; ?><?php if(isset($_SESSION['id']) AND($_SESSION['id'] == 57 OR $_SESSION['id'] == 52) ){ ?><a href="blog.php?idarticle=<?php echo $donne['id'] ?>">Supprimer</a> </h1><?php  }else{ ?> </h1><?php } ?>
           <p><?php echo nl2br($donne['contenu']); ?></p><br/>
           <span><?php echo  '-Ecrit par ' .$donne['pseudo'].'  le '.$donne['date_r']; ?></span><br/><br/>
           <div id="commentaire"><a href="blog.php?articleid=<?php echo $donne['id']; ?>">Voir les commentaires.</a></div>
           <br/><br/>
         </div>
         <?php
       }
       ?>
     </p>
     <br/>
   </div>
   <?php
 }
 ?>
</div>
<?php include('include/footer.php'); ?>
<?php include('include/script.php'); ?>
</body>
</html>