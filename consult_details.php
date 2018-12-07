<html>
<body>
	<?php
	$host = "db.ist.utl.pt";
	$user = "istxxxxxx";
	$pass = "xxxxxxxx";
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

	$VAT_client = $_REQUEST["VAT_client"];
	$animal_name = $_REQUEST["animal_name"];
	$VAT_owner = $_REQUEST["VAT_owner"];
	$date_timestamp = $_REQUEST["date_timestamp"];

	$stmt1 = $connection->prepare("SELECT a.name, a.VAT AS VAT_o, a.species_name, a.gender, a.colour, a.birth_year, a.age, c.s, c.o, c.a, c.p, c.weight, cd.code, p.name_med, p.dosage, p.lab, p.regime
								   FROM animal a NATURAL JOIN consult c NATURAL LEFT OUTER JOIN consult_diagnosis cd NATURAL LEFT OUTER JOIN prescription p
								   WHERE a.name = :animal_name
								   AND a.vat = :VAT_owner
								   AND c.date_timestamp = :date_timestamp");
	if ($stmt1 == FALSE)
	{
		$info = $connection->errorInfo();				
		echo("<p>Error: {$info[2]}</p>");
		exit();
	}
	$stmt1->execute(array(":animal_name" => $animal_name, 
						  ":VAT_owner" => $VAT_owner,
						  ":date_timestamp" => $date_timestamp));

	$nrows1 = $stmt1->rowCount();

	if ($nrows1 == 0)
	{
		echo("<h2>Consult of $animal_name on date: ${date_timestamp} with empty data.</h2>");
	}
	else 
	{
		echo("<h2>Consult of $animal_name on date: ${date_timestamp}</h2>");
		echo("<table border=\"2\">");
		echo("<tr><td>Animal name</td><td>VAT_owner</td><td>Species name</td><td>Colour</td><td>Gender</td><td>Birth year</td><td>Age</td><td>S</td><td>O</td><td>A</td><td>P</td><td>Weight</td><td>Diagnostic code</td><td>Medicine name</td><td>Dosage</td><td>Lab</td><td>Regime</td></tr>");
		foreach($stmt1 as $row)
		{
			echo("<tr>\n");
			echo("<td>{$row['name']}</td>\n");
			echo("<td>{$row['VAT_o']}</td>\n");
			echo("<td>{$row['species_name']}</td>\n");
			echo("<td>{$row['colour']}</td>\n");
			echo("<td>{$row['gender']}</td>\n");
			echo("<td>{$row['birth_year']}</td>\n");
			echo("<td>{$row['age']}</td>\n");
			echo("<td>{$row['s']}</td>\n");
			echo("<td>{$row['o']}</td>\n");
			echo("<td>{$row['a']}</td>\n");
			echo("<td>{$row['p']}</td>\n");
			echo("<td>{$row['weight']}</td>\n");
			echo("<td>{$row['code']}</td>\n");
			echo("<td>{$row['name_med']}</td>\n");
			echo("<td>{$row['dosage']}</td>\n");
			echo("<td>{$row['lab']}</td>\n");
			echo("<td>{$row['regime']}</td>\n");
			echo("</tr>\n");
		}
		echo("</table>");
	}

	$connection = null;
	?>

	<br> </br>

	<form action="consults.php" method="post">
		<h3>See your previous consults</h3>
		<p><input type="hidden" name="VAT_client" value="<?=$VAT_client?>"/></p>
		<p><input type="hidden" name="animal_name" value="<?=$animal_name?>"/></p>
		<p><input type="hidden" name="VAT_owner" value="<?=$VAT_owner?>"/></p>
		<p><input type="submit" value="BACK"/></p>
	</form>
	
	<br> </br>
	<form action="introduce_data.php" method="post">
		<h3>Go back to Homepage</h3>
		<p><input type="submit" value="HOME"/></p>
	</form>
</body>
</html>
