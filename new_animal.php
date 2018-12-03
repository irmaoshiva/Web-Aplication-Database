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
	$species_name = $_REQUEST['species_name'];
	$colour = $_REQUEST['colour'];
	$gender = $_REQUEST['gender'];
	$birth_year = $_REQUEST['birth_year'];
	$sql1 = "INSERT INTO animal VALUES ('$animal_name', $VAT_client, '$species_name', '$colour', '$gender', '$birth_year', 10)";
	echo("<p>$sql</p>");
	$nrows1 = $connection->exec($sql1);
	if($nrows1)
	{
		echo("<h2>Animal Successfully Registered</h2>");
		echo("<p>Rows inserted: $nrows</p>");
	}
	else
	{
		echo("<h2>Error in inserting the new animal into the database</h2>");
		$sql2 = "SELECT * FROM client WHERE VAT = '$VAT_client'";
		$nrows2 = $connection->exec($sql2);
		if(!$nrows2)
		{
			echo("<h3>Please insert manually through the MySQL command line prompt the information of the new Client</h3>");
		}
		else
		{
			echo("<h3>Please confirm the entered data</h3>");
		}
		echo("<form action='new_animal.php' method='post'>		
			  	<p><input type='submit' value='BACK'/></p>
			  </form>");
	}
	$connection = null;
	?>
</body>
</html>
