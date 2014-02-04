<?php
// On prolonge la session
session_start(); 

// On teste si la variable de session existe et contient une valeur
if(empty($_SESSION['login']))
  { // Si inexistante ou nulle, on redirige vers le formulaire de login
   header('Location: auth1.php');
    exit();
  }
 else {
   require_once('Auth.php');
   require_once('connect.php');
   $utilisateur=$_SESSION['login'];
   // on teste si l'on n'a pas depasse le temps de session
   $timeout=120;
   $session=new Auth(SERVER,BASE,USER,PASSWD,$timeout);
   //$session->lire_info($utilisateur); 
   if($session->temps_connexion($utilisateur)>$session->get_temps_max())
     header('Location: deconnexion.php');
   echo  "<h1>Bienvenue ".$_SESSION['login']."</h1>";
   echo "<p> Votre session précédente a été  ouverte le "
   .$_SESSION["prec_connect"]." et a duré :<b>"
   .$_SESSION["prec_duree"]." secondes</b>";
   echo "<p> Votre navigateur était :".
   $_SESSION["prec_navigateur"]." </p>"; 
   echo "<p> Vous étiez connecté avec le sid :"
   .$_SESSION["prec_session_id"]."</p>";
   echo "<p> Votre session actuelle a été  ouverte le "
   .$_SESSION["derniere_connect"].
   " et a duré <b>:".$session->get_temps_max()
   ."secondes </b>";
   echo "<p> Votre navigateur est :"
   .$_SESSION["navigateur"]." </p>"; 
   echo "<p> Vous vous êtes connecté avec le sid :"
   .$_SESSION["session_id"]."</p>";
   echo "pour vous deconnecter:";
 }
?>
<html><head>
<meta charset="utf-8">
<title>Administration</title>
</head> 
<body>
	<fieldset>
	<legend>fin de session</legend>
<input type="button" value="deconnecter" onclick=
"document.location.replace('deconnexion.php')">
	</fieldset>
</body>
</html>

	
