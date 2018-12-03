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
	$VAT_client = $_REQUEST['VAT_client'];
	$animal_name = $_REQUEST['animal_name'];
	$owner_name = $_REQUEST['owner_name'];
	$sql = "SELECT a.name AS a_name, p.name AS o_name 
			FROM person p INNER JOIN animal a ON (p.VAT = a.VAT) 
			WHERE a.name = '$animal_name' 
			AND p.name like '%$owner_name%'";
	/* ISTO ERA PARA QUE? #pedro
	$sql = $dbh->prepare("SELECT a.name as animal_name, p.name as owner_name FROM person p INNER JOIN animal a ON (p.VAT = a.VAT) WHERE a.name = :animal_name AND p.name like '%:owner_name%'");
	$sql->execute(array(':animal_name' => $animal_name, ':owner_name' => $owner_name));
	*/
	/*echo("<p>$sql</p>");*/
	$result = $connection->query($sql);
	$nrows = $result->rowCount();
	if ($nrows == 0)
	{
		echo("<h2>Animal Not Found</h2>");
		echo("<h3>If you want to register the animal in the veterinary hospital, please enter the following data:</h3>");
		echo("<form action='new_animal.php' method='post'>
				<p><input type=hidden name='VAT_client'
			value='$VAT_client'/></p>
				<p><input type=hidden name='animal_name'
			value='$animal_name'/></p>
				<p>Species Name: <input type='text' name='species_name'/></p>
				<p>Colour: <input type='text' name='colour'/></p>
				<p>Gender: <input type='text' name='gender'/></p>
				<p>Birth Year (Y-M-D): <input type='text' name='birth_year'/></p>
				<p><small><u>NOTE:</u> Name and VAT owner were already used in the data previously entered. Age is automatically calculated.</small></p>		
				<p><input type='submit' value='SUBMIT'/></p>
			</form>");
	}
	else
	{	
		echo("<h2>Animal is already registered</h2>");
		echo("<h3>Matching Animals</h3>");
		echo("<table border=\"2\">");
		echo("<tr><td>Animal Name</td><td>Owner Name</td><td>Previous consults involved the VAT for the client '$VAT_client'</td></tr>");
		foreach($result as $row)
		{
			echo("<tr>\n");
			echo("<td>{$row['a_name']}</td>\n");
			echo("<td>{$row['o_name']}</td>\n");
			echo("<td><a href=\"consults.php?VAT_client=$VAT_client&animal_name=$animal_name"); /*nova versão (2 inputs) */ 
			/*echo("<td><a href=\"consults.php?VAT_client="); versão antiga */
			/*echo($VAT_client);  versão antiga */
			echo("\">ConsultsHistory/AddConsult</a></td>\n");
			echo("</tr>\n");
		}
		echo("</table>");
	}
	$connection = null;
	?>
</body>
</html>
