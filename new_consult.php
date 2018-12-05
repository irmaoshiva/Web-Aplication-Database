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
	$VAT_owner = $_REQUEST['VAT_owner'];
	$date_timestamp =$_REQUEST['date_timestamp'];
	$S = $_REQUEST['s'];
	$O = $_REQUEST['o'];
	$A = $_REQUEST['a'];
	$P = $_REQUEST['p'];
	$VAT_client = $_REQUEST['VAT_client'];
	$VAT_vet = $_REQUEST['VAT_vet'];
	$weight = $_REQUEST['weight'];
	$code = $_REQUEST['code'];

	echo("<p>$animal_name</p>");
	echo("<p>$VAT_owner</p>");
	echo("<p>$date_timestamp</p>");
	echo("<p>$S</p>");
	echo("<p>$O</p>");
	echo("<p>$A</p>");
	echo("<p>$P</p>");
	echo("<p>$VAT_client</p>");
	echo("<p>$VAT_vet</p>");
	echo("<p>$weight</p>");
	echo("<p>$code</p>");


	$stmt1 = $connection->prepare("INSERT INTO consult VALUES (:animal_name, :VAT_owner, :date_timestamp, :S, :O, :A, :P, :VAT_client, :VAT_vet, :weight)");
	if ($stmt1 == FALSE)
	{
		$info = $connection->errorInfo();				
		echo('<p>Error: {$info[2]}</p>');
		exit();
	}
	$stmt1->execute(array(':animal_name' => $animal_name, 
						  ':VAT_owner' => $VAT_owner,
						  ':date_timestamp' => $date_timestamp,
						  ':S' => $S,
						  ':O' => $O,
						  ':A' => $A,
						  ':P' => $P,
						  ':VAT_client' => $VAT_client,
						  ':VAT_vet' => $VAT_vet,
						  ':weight' => $weight));

	$stmt2 = $connection->prepare("INSERT INTO consult_diagnosis VALUES (:code, :animal_name, :VAT_owner, :date_timestamp)");
	if ($stmt2 == FALSE)
	{
		$info = $connection->errorInfo();				
		echo('<p>Error: {$info[2]}</p>');
		exit();
	}
	$stmt2->execute(array(':code' => $code,
						  ':animal_name' => $animal_name, 
						  ':VAT_owner' => $VAT_owner,
						  ':date_timestamp' => $date_timestamp));

	?>

	<h2>Consult Successfully Registered</h2>
	
	<br> </br>

	<form action='consults.php' method='post'>
		<h3>See the consults in the database and your previous consults</h3>
		<p><input type=hidden name='VAT_client' value='<?=$VAT?>'/></p>
		<p><input type=hidden name='animal_name' value='<?=$animal_name?>'/></p>
		<p><input type=hidden name='owner_name' value='<?=$owner_name?>'/></p>
		<p><input type='submit' value='BACK'/></p>
	</form>

	<?php	
	$connection = null;
	?>
</body>
</html>
