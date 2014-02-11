<?php
//Definition des constantes et des variables
require_once('connect.php');

$errorMessage = '';

//Test de l'envoi du formulaire
if(!empty($_POST))
{

   //Les identigiants sont transmis ?
   if(!empty($_POST['login']) && !empty($_POST['password']))
   {

     //On ouvre la session
     session_start();
     //On enregistre le login en session
     $_SESSION['login'] = $_POST['login'];
     $_SESSION['password'] = $_POST['password'];
     //On redirige vers le fichier planning.php
     header('Location: planning.php');
   }
   else
   {
      $errorMessage = 'Veuillez inscrire vos identifiants svp !';
   }
}
?>


<!DOCTYPE HTML>
<html lang="fr">
  <head>
    <title> Affichage </title>
  </head>

<?php
   if(!empty($errorMessage))
   {
      echo $errorMessage;
   }
?>

  <body>
    <form action="affichage.php" method="post">
      <fieldset>
	<legend> Planning </legend>

        <p>
	  <label for="login"> Login :</label>
	  <input type="text" name="login" value="" />
	</p>

        <p>
	  <label for="password"> Password :</label>
	  <input type="text" name="password" value="" />
          <input type="submit" value="Voir planning" />
	</p>


      </fieldset>
    </form>
  </body>
</html>