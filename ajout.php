<?php
require("config.php");


// Vérification préalable à l'insertion en Base
$sql="SELECT * from utilisateur where login=:login";
$stmt=$connexion->prepare($sql);
$stmt->bindParam(':login', $_GET['login']);
$stmt->execute();

if (!$stmt) echo "Pb d'accès à la table";
else if ($stmt->rowCount()==0){
	$sql="INSERT into utilisateur (login,password) values(:login,:password)";
	$stmt=$connexion->prepare($sql);
	$stmt->bindParam(':login', $_GET['login']);
	$stmt->bindParam(':password', $_GET['password']);
	$stmt->execute();
	
	if (!$stmt) echo "Pb d'insertion";
	else {
		echo $_GET['login']." insérée en base !";
		}
	}
	else { 
		echo "Une personne de meme LOGIN existe deja dans la Base !";
	}
?>

<!doctype html>
<html>
<head>
<title>Ajout de la personne</title>
<meta charset="utf-8">
</head>
<body>
<form action="ajout.php" method=get>
<fieldset>
<legend> Ajouter une personne</legend>

<p>
<label for="login"> Login : </label>
<input type=text name=login value="" />
</p>

<p>
<label for="password"> Password : </label>
<input type="password" name="password" value=""/>
<input type="submit" name="submit" value="Ajouter la personne"/>
</p>

<input type="button" name="Authentification" value="Revenir à l'authentification" onclick="self.location.href='authBD.php'"/>
</fieldset>
</form>
</body>

</html>

</body>
</html>
