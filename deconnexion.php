<?php 
	session_start();
	echo "Au revoir, ".$_SESSION['login']." vous avez été déconnecté !";
	session_destroy();
?>


<!DOCTYPE HTML>
<html lang="fr">
<head>
<title> Formulaire d'authentification</title>
</head>
<body>
<form>
<p>
<input type="button" name="Auth" value="Retour à l'accueil" onclick="self.location.href='authBD.php'"/>