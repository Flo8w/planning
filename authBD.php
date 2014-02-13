<?php
require_once("config.php");

    
$errorMessage='';

//Test de l'envoi du formulaire
if(!empty($_POST))
{
	//Les identifiants sont transmis ?
	if(!empty($_POST['login']) && !empty($_POST['password']))
	{
		//Sont-ils ceux attendus ?
		$stmt = $connexion->prepare("SELECT * from utilisateur where login= :log and password=:pass");
		$stmt->bindParam(':log', $_POST['login']);
		$stmt->bindParam(':pass', $_POST['password']);
		$stmt -> execute();
		
		if($stmt->rowCount()!=1)
		{
				$errorMessage = "Problème d'authentification";
		}
		else
		{
			//On ouvre la session
			session_start();
			//On enregistre le login en variable de session
			$_SESSION['password']=$_POST['password'];
			$_SESSION['login']=$_POST['login'];
			//On redirige vers le fichier suite.php
			header('Location: suite.php');
	}
}
else
{
	$errorMessage= 'Veuillez inscrire vos identifiants !';
}
}
?>

<!DOCTYPE HTML>
<html lang="fr">
<head>
<title> Formulaire d'authentification</title>
</head>
<body>

<?php if (!empty($errorMessage)){
	echo $errorMessage;
}
?>
<form action="authBD.php" method=post>
<fieldset>
<legend> Identifiez-vous</legend>

<p>
<label for="login"> Login : </label>
<input type=text name=login value="" />
</p>

<p>
<label for="password"> Password : </label>
<input type="password" name="password" value=""/>
<input type="submit" name="submit" value="Se logger"/>
</p>

<input type="button" name="Ajouter" value="S'inscrire" onclick="self.location.href='ajout.php'"/>
 </fieldset>
</form>
</body>

</html>
