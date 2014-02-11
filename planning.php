<?php
session_start();

require_once ("config.php");

$sql="SELECT * from creer where utilisateur=(select id from utilisateur where login=:login and password=:password)";
$stmt=$connexion->prepare($sql);
$stmt->bindParam(':login',$_SESSION['login']);
$stmt->bindParam(':password',$_SESSION['password']);
$stmt->execute();

if($stmt->rowCount() == 0)
{
  echo "Aucune activité programmée";
}
else //Tout va bien
{
  echo $_SESSION['login']."<br/>";
  foreach($stmt as $plan){
    echo $plan[2]."h : ".$plan[1]."<br/>";
  }     
}

?>

<form action="affichage.php" method="POST">
<input type='submit' value='retour'>
</form>