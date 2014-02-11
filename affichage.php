<?php
//Definition des constantes et des variables
require_once('connect.php');
$dsn="mysql:dbname=".BASE.";host=".SERVER;
try{
  $connexion=new PDO($dsn,USER,PASSWD);
}
catch(PDOException $e){
  printf("Echec de la connexion : %s\n", $e->getMessage());
  exit();
}

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

     /*
     $sql="SELECT * from creer where utilisateur=(select id from utilisateur where login=:login and password=:password)";
     $stmt=$connexion->prepare($sql);
     $stmt->bindParam(':login',$_POST['login']);
     $stmt->bindParam(':password',$_POST['password']);
     $stmt->execute();

     if($stmt->rowCount() == 0)
     {
       $errorMessage = "Aucune activité programmée";
     }
     else //Tout va bien
     {

       echo $_POST['login']."<br/>";
       foreach($stmt as $plan){
	 echo $plan[2]."h : ".$plan[1]."<br/>";
       }

       
       //On ouvre la session
       session_start();
       //On enregistre le login en session
       $_SESSION['login'] = $_POST['login'];
       //On redirige vers le fichier planning.php
       header('Location: planning.php');
 
       
     }*/
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