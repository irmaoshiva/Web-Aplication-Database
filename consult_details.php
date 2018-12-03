<html>
<body>
	<?php
	$host = "db.ist.utl.pt";
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
	$VAT_client = $_REQUEST['VAT_client'];
	$animal_name = $_REQUEST['animal_name'];
	$date_timestamp = $_REQUEST['date_timestamp'];
	$sql = "SELECT a.name, a.gender, a.species_name, a.colour, a.age, a.birth_year, c.s, c.o, c.a, c.p, c.weight, cd.code, p.name_med, p.dosage, p.lab, p.regime
			FROM animal a NATURAL JOIN consult c NATURAL LEFT OUTER JOIN consult_diagnosis cd NATURAL LEFT OUTER JOIN prescription p
			WHERE a.vat = $VAT_client
			AND a.name = '$animal_name'
			AND c.date_timestamp = '$date_timestamp';";
	/*echo("<p>$sql</p>");*/
	$result = $connection->query($sql);
	$nrows = $result->rowCount();
	if ($nrows == 0)
	{
		echo("<h2>Consult of date: ${date_timestamp} with empty data.</h2>");
	}
	else 
	{
		echo("<h2>Consult of date: ${date_timestamp}</h2>");
		echo("<table border=\"2\">");
		echo("<tr><td>Animal name</td><td>Gender</td><td>Species name</td><td>Colour</td><td>Age</td><td>Birth year</td><td>S</td><td>O</td><td>A</td><td>P</td><td>Weight</td><td>Diagnostic code</td><td>Medicine name</td><td>Dosage</td><td>Lab</td><td>Regime</td></tr>");
		foreach($result as $row)
		{
			echo("<tr>\n");
			echo("<td>{$row['name']}</td>\n");
			echo("<td>{$row['gender']}</td>\n");
			echo("<td>{$row['species_name']}</td>\n");
			echo("<td>{$row['colour']}</td>\n");
			echo("<td>{$row['age']}</td>\n");
			echo("<td>{$row['birth_year']}</td>\n");
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
</body>
</html>