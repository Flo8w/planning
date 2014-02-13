<?php
	require("config.php");
	session_start();
$errorMessage='';
//Test de l'envoi du formulaire
//if(!empty($_POST))
//{
	//Les identifiants sont transmis ?
	//if(!empty($_POST['activite']) && !empty($_POST['heure']))
	//{

	if(!empty($_POST)){
		$connexion->beginTransaction();
		$req="SELECT id from utilisateur where login =:log";
		$stm=$connexion->prepare($req);
		$stm->bindParam(':log',$_SESSION['login']);
		$stm->execute();
		$donnes = $stm->fetch(PDO::FETCH_BOUND);
		
		
		$varDate = str_replace('/','-',$_POST['dateDebut']);
		$newDate = date('Y-m-d', strtotime($varDate));
		
		$req="INSERT into planning values(:he,:da)";
		$stm=$connexion->prepare($req);
		$stm->bindParam(':he',$_POST['heure']);
		$stm->bindParam('da',$newDate);
		$stm->execute();
		print_r($stm->errorInfo());
		
		//Sont-ils ceux attendus ?
		
		$sql="INSERT into creer values(:id,:act,:heu,:dat)";
		$stmt = $connexion->prepare($sql);
		$stmt->bindParam(':id',$donnes);
		$stmt->bindParam(':act', $_POST['activite']);
		$stmt->bindParam(':heu',$_POST['heure']);
		$stmt->bindParam(':dat',$newDate);
		//$connexion->errorInfo();
		$stmt -> execute();
		print_r($connexion->errorInfo());
		print_r($stmt->errorInfo());
		$connexion->commit();
				if (!$stmt) echo "Pb d'insertion";
		else {
			echo "L'activité a été ajouté"."<br/>";
			}
	
	
	}
	else{
		echo "Fail";
	}
		//header('Location: suite.php');$sql="INSERT into utilisateur values(:id,:login,:password)";
	
//}
//else
//{
//	$errorMessage= 'Veuillez remplir les champs !';
//}
?>
	
	
<!DOCTYPE HTML>
<html lang="fr">
<head>
<title> Ajout d'une activité</title>
<meta charset="utf-8"/>
<script language="javascript">
moisX=["","Janvier","Fevrier","Mars","Avril","Mai","Juin","Juillet","Aout","Septembre","Octobre","Novembre","Decembre"];
JourM=["Di","Lu","Ma","Me","Je","Ve","Sa"];

var fermable_microcal=true;
var select_old= null;

var startWeek=0;//debut de la semaine 0=dim,1=lun,...
var jourPause={0:true,6:true}; //jour de pause de la semaine
var jourFeriee={"1-1":"jour an","1-5":"fête du travail","8-5":"armistice","14-7":"fête nationale","15-8":"ascencion","1-11":"armistice","11-11":"toussain","25-12":"noel"};

//structure la date 
function strucDate(dateX) 
{return {"pos":dateX.getDay(),"jour":dateX.getDate(),"mois":dateX.getMonth()+1,"annee":dateX.getFullYear()};}

var dateS= strucDate(new Date());//date Selectionné
var dnow= strucDate(new Date());//date actuelle

//retourne le ième jour du 1er du mois
function premJourMois(mois,annee) 
{return (new Date(annee,mois-1,1).getDay());}
//retourne le jour max du mois
function JmaxMois(mois,annee) 
{return (new Date(annee,mois,0).getDate());}

/* Test une date si elle est correct...spécial killer*/
function testTypeDate(dateEntree)
{
tst=false;
try
{rc=dateEntree.split("/");nd=new Date(rc[2],(rc[1]-1),rc[0]);
tst=(rc[2]>1800&&rc[2]<2200&&rc[2]==nd.getFullYear()&&rc[1]==(nd.getMonth()+1)&&rc[0]==nd.getDate());
} catch(e) {}
return tst;
}

//selection de la zone avec la souris
function choix(koi,code)
{
if (code) 
{  select_old= koi.style.background;
   koi.style.background ='#c0c0FF';
}
else 
{
koi.style.background =select_old;
}
}

function testTravail(oldX,xx,jj,mm,aa)
{
styleX="font-family:Tahoma;font-size:10px;text-align:center;";
styleX+=(oldX)?"":"color:#e0e0e0;";
styleX+="cursor:hand;border-right:1px #e0e0e0 solid;border-bottom:1px #e0e0e0 solid;";
if (jourPause[xx]||jourFeriee[jj+"-"+mm]!=null) styleX+="background:#f0f0f0;";
if (jj==dnow.jour&&mm==dnow.mois&&aa==dnow.annee) styleX+="border:2px red solid;";
return styleX;
}

//test si année bissextile
function bissextile(annee) {
return (annee%4==0 && annee %100!=0 || annee%400==0);
}

//Retourne le nombre de jour depuis le 1er janvier (num de semaine)
function nbJAnnee(dateX){
var nb_mois=[,0,31,59,90,120,151,181,212,243,273,304,334];
j=dateX.jour ; m=dateX.mois ; a=dateX.annee;
nb=nb_mois[m]+j-1 ;
if (bissextile(a) && m>2) nb++;
return nb;
}

//affiche le calendrier
function view_microcal(actif,ki,source,mxS,axS)
{
if (actif)
{
//decalage du mois su on clique sur -/+
if (mxS!=-1) 
{
clearTimeout(cc);
ki.focus();
fermable_microcal=true;
dateS.mois=mxS;
dateS.annee=axS;
if (dateS.mois<1) {dateS.annee--;dateS.mois+=12;}
if (dateS.mois>12) {dateS.annee++;dateS.mois-=12;}
}
//init
Dstart=(premJourMois(dateS.mois,dateS.annee)+7-startWeek)%7;
jmaxi=JmaxMois(dateS.mois,dateS.annee);
jmaxiAvant=JmaxMois((dateS.mois-1),dateS.annee);
//si on veux ajouter le numero de la semaine ...
//idxWeek=parseInt(nbJAnnee(strucDate(new Date(dateS.mois+'-01-'+dateS.annee)))/7,10)+1;

ymaxi=parseInt((jmaxi+Dstart+1)/7,10);

//generation du tableau
//--entête
htm="<table><tr style='font-size:10px;font-family:Tahoma;text-align:center;'>";
htm+="<td style='cursor:hand;' onclick=\"view_microcal(true,"+ki.id+","+source.id+","+(dateS.mois-1)+","+dateS.annee+");\">-</td>";
htm+="<td colspan='5'> <b> "+moisX[dateS.mois]+"</b>&nbsp;"+dateS.annee+"</td>";
htm+="<td  style='cursor:hand;' onclick=\"view_microcal(true,"+ki.id+","+source.id+","+(dateS.mois+1)+","+dateS.annee+")\">+</td></tr>";
//--corps
htm+="<tr>";
//affichage des jours DLMMJVS
for (x=0;x<7;x++) 
htm+="<td  style='font-size:10px;font-family:Tahoma;'><b>"+JourM[(x+startWeek)%7]+"</b></td>";
htm+="</tr>"

//------------------------
for (y=0;y<=ymaxi;y++)
{
htm+="<tr>";
for (x=0;x<7;x++)
{
idxP=y*7+x-Dstart+1;   //numero du jour
aa=dateS.annee;
xx=(x+startWeek)%7;
//jour du mois précedent
if (idxP<=0)
{
jj=idxP+jmaxiAvant;mm=dateS.mois-1;
if (mm==0)
{mm=12;aa--;}
htm+="<td style='"+testTravail(false,xx,jj,mm,aa)+"' onmouseover='choix(this,true)' onmouseout='choix(this,false)'  onclick=\""+(ki.id)+".value='"+((jj<10)?"0":"")+jj+"/"+((mm<10)?"0":"")+mm+"/"+aa+"';"+(ki.id)+".style.color='black';\">"+jj+"</td>";
}
else if (idxP>jmaxi) //jour du mois suivant
{
jj=idxP-jmaxi;mm=dateS.mois+1;
if (mm==13)
{mm=1;aa++;}

htm+="<td style='"+testTravail(false,xx,jj,mm,aa)+"' onmouseover='choix(this,true)' onmouseout='choix(this,false)'  onclick=\""+(ki.id)+".value='"+((jj<10)?"0":"")+jj+"/"+((mm<10)?"0":"")+mm+"/"+aa+"';"+(ki.id)+".style.color='black';\">"+jj+"</td>";}
else //jour du mois en cours
{
jj=idxP;mm=dateS.mois;
htm+="<td style='"+testTravail(true,xx,jj,mm,aa)+"' onmouseover='choix(this,true)' onmouseout='choix(this,false)'  onclick=\""+(ki.id)+".value='"+((jj<10)?"0":"")+jj+"/"+((mm<10)?"0":"")+mm+"/"+aa+"';"+(ki.id)+".style.color='black';\">"+jj+"</td>";}
}
htm+="</tr>"
}//-------------------------
htm+="</table>"
//affiche le tableau
source.innerHTML=htm;
source.style.visibility="";
} else
{
//ferme le calendrier
if (fermable_microcal) 
   cc=setTimeout(source.id+".style.visibility='hidden'",500);
}
}
</script>
</head>
<body>

<?php if (!empty($errorMessage)){
	echo $errorMessage;
}
?>
<form action="ajoutAct.php" method=post>
<fieldset>

<p>
<label for="activite"> Activité : </label>
<SELECT name="activite">
<OPTION value="java"> Java</OPTION>
<OPTION value="python"> Python</OPTION>
<OPTION value="Anglais">Anglais</OPTION>
<OPTION value="Repos"> Repos</OPTION>
<OPTION value="Café"> Café</OPTION>
<OPTION value="PHP"> PHP</OPTION>
</SELECT>
</p>



<p>
<label for="date"> Date : </label>
<table>
<tr><td ><input type="text" maxlength="10" name="dateDebut" id="dateDebut" onfocus="view_microcal(true,dateDebut,microcal,-1,0);" onblur="view_microcal(false,dateDebut,microcal,-1,0);" onkeyup="this.style.color=testTypeDate(this.value)?'black':'red'"></td></tr>
<tr><td><div id="microcal" style="visibility:hidden;position:absolute;border:2px red dashed;background:#ffffff;"></div></td></tr>
</table>
</p>


<p>
<label for="heure"> Heure : </label>
<SELECT name="heure">
<OPTION value="8"> 8h </OPTION>
<OPTION value="9">9h </OPTION>
<OPTION value="10" >10h </OPTION>
<OPTION value="11">11h </OPTION>
<OPTION value="12">12h </OPTION>
<OPTION value="13"> 13h</OPTION>
<OPTION value="14"> 14h</OPTION>
<OPTION value="15">15h</OPTION>
<OPTION value="16">16h</OPTION>
<OPTION value="17">17h</OPTION>
<OPTION value="18">18h</OPTION>
<OPTION value="19">19h</OPTION>
<OPTION value="20"> 20h</OPTION>
</SELECT></p>
</p>
<input type="submit" name="submit" value="Ajouter une activité"/>
 </fieldset>
</form>
<form>
 <p>
 <input type="button" name="Menu" value="Retour au menu principal" onclick="self.location.href='suite.php'"/>
 </p>
</form>
</body>

</html>
