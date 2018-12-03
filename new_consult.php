<html>
<body>
	<?php
	$host = "db.tecnico.ulisboa.pt";
	$user = "ist425330";
	$pass = "acdo1863";
	$dsn = "mysql:host=$host;dbname=$user";
	try
	{
		$connection = new PDO($dsn, $user, $pass);
	}
	catch(PDOException $exception)
	{
		echo("<p>Error: ");
		echo($exception->getMessage());
		echo("</p>");
		exit();
	}
	$animal_name = $_REQUEST['animal_name'];
	$VAT_client = $_REQUEST['VAT_client'];
	$date_timestamp =$_REQUEST['date_timestamp'];
	$S = $_REQUEST['S'];
	$O = $_REQUEST['O'];
	$A = $_REQUEST['A'];
	$P = $_REQUEST['P'];
	$VAT_owner = $_REQUEST['VAT_owner'];
	$VAT_vet = $_REQUEST['VAT_vet'];
	$weight = $_REQUEST['weight'];
	$code = $_REQUEST['code'];
	$sql1 = "INSERT INTO consult VALUES ('$animal_name',  $VAT_client,'$date_timestamp','$S','$O','$A','$P',$VAT_owner,$VAT_vet,$weight)";
	$sql2 = "INSERT INTO consult_diagnosis VALUES ('$code','$animal_name',$VAT_owner,'$date_timestamp')";
	$nrows1 = $connection->exec($sql1);
	/*echo("<p>$sql1</p>");*/
	$nrows2 = $connection->exec($sql2);
	/*echo("<p>$sql2</p>");*/

	if(nrows1 and nrows2)
		echo("<h2>Animal Successfully Registered</h2>");
	$connection = null;
	?>
</body>
</html>
