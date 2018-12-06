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

	$animal_name = $_REQUEST["animal_name"];
	$VAT_owner = $_REQUEST["VAT_owner"];
	$date_timestamp =$_REQUEST["date_timestamp"];
	$S = $_REQUEST["s"];
	$O = $_REQUEST["o"];
	$A = $_REQUEST["a"];
	$P = $_REQUEST["p"];
	$VAT_client = $_REQUEST["VAT_client"];
	$VAT_vet = $_REQUEST["VAT_vet"];
	$weight = $_REQUEST["weight"];
	$diagnosis_code = $_REQUEST["diagnosis_code"];

	$stmt1 = $connection->prepare("INSERT INTO consult VALUES (:animal_name, :VAT_owner, :date_timestamp, :S, :O, :A, :P, :VAT_client, :VAT_vet, :weight)");
	if ($stmt1 == FALSE)
	{
		$info = $connection->errorInfo();				
		echo("<p>Error: {$info[2]}</p>");
		exit();
	}
	$test = $stmt1->execute(array(":animal_name" => $animal_name, 
								  ":VAT_owner" => $VAT_owner,
								  ":date_timestamp" => $date_timestamp,
								  ":S" => $S,
								  ":O" => $O,
								  ":A" => $A,
								  ":P" => $P,
								  ":VAT_client" => $VAT_client,
								  ":VAT_vet" => $VAT_vet,
								  ":weight" => $weight));
	if ($test == FALSE)
	{
		$info = $connection->errorInfo();
		echo("<h3>Consult is already in the Database</h3>");	
		echo("<p></p>");					
		echo("<p>Error: {$info[2]}</p>");
		exit();
	}

	$stmt2 = $connection->prepare("INSERT INTO consult_diagnosis VALUES (:code, :animal_name, :VAT_owner, :date_timestamp)");
	if ($stmt2 == FALSE)
	{
		$info = $connection->errorInfo();				
		echo("<p>Error: {$info[2]}</p>");
		exit();
	}
	foreach ($diagnosis_code as $code ) {
		$test = $stmt2->execute(array(":code" => $code,
									  ":animal_name" => $animal_name, 
									  ":VAT_owner" => $VAT_owner,
									  ":date_timestamp" => $date_timestamp));
		if ($test == FALSE)
		{
			$info = $connection->errorInfo();
			echo("<h3>Consult Diagnosis is already in the Database</h3>");	
			echo("<p></p>");				
			echo("<p>Error: {$info[2]}</p>");
			exit();
		}
	}

	?>

	<h2>Consult Successfully Registered</h2>
	
	<br> </br>

	<form action="consults.php" method="post">
		<h3>See the new consult in the database and your previous consults</h3>
		<p><input type="hidden" name="VAT_client" value="<?=$VAT_client?>"/></p>
		<p><input type="hidden" name="animal_name" value="<?=$animal_name?>"/></p>
		<p><input type="hidden" name="VAT_owner" value="<?=$VAT_owner?>"/></p>
		<p><input type="submit" value="BACK"/></p>
	</form>

	<?php	
	$connection = null;
	?>
	<br> </br>
	<form action="introduce_data.php" method="post">
		<h3>Go back to Homepage</h3>
		<p><input type="submit" value="HOME"/></p>
	</form>
</body>
</html>
