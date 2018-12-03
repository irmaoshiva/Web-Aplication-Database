<html>
<body>
	<?php
	$host = "db.tecnico.ulisboa.pt";
	$user = "ist426527";
	$pass = "hith1616";
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
	$species_name = $_REQUEST['species_name'];
	$colour = $_REQUEST['colour'];
	$gender = $_REQUEST['gender'];
	$birth_year = $_REQUEST['birth_year'];
	$sql = "INSERT INTO animal VALUES ('$animal_name', $VAT_client, '$species_name', '$colour', '$gender', '$birth_year', 10)";
	echo("<p>$sql</p>");
	$nrows = $connection->exec($sql);
	echo("<p>Rows inserted: $nrows</p>");
	if($nrows)
		echo("<h2>Animal Successfully Registered</h2>");
	$connection = null;
	?>
</body>
</html>
