<?php
	session_start();
	if(!empty($_SESSION['login']))
{
	echo "Bienvenue ". $_SESSION['login']."<br/>";
	echo "<br/>";
}
	else
	{
		header('Location: authBD.php');
	}
?>

<!DOCTYPE HTML>
<html lang="fr">
<head>
<title> Menu principal</title>
<meta charset="utf-8">
</head>
<body>
	<form>
	<fieldset>
	
	<input type="button" name="Ajout activité" value="Ajouter une activité" onclick="self.location.href='ajoutAct.php'"/>
	<input type="button" name="Afficher activités" value="Afficher les activités" onclick="self.location.href='planning.php'"/>
	</fieldset>
	</form>
	
	<form action="deconnexion.php" method="post">
	<input type='submit' value='Déconnexion'>
	</form>

