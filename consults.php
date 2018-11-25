<html>
<body>
	<?php
	$host = "db.ist.utl.pt";
	$user = "ist425306";
	$pass = "zfjy5090";
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
	$sql = "SELECT a.name, date_timestamp
			FROM animal a NATURAL JOIN consult 
			WHERE a.vat = $VAT_client
			AND a.name = '$animal_name';";
	/*echo("<p>$sql</p>");*/
	$result = $connection->query($sql);
	$nrows = $result->rowCount();
	if ($nrows == 0)
	{
		echo("<h2>Previous Consults Not Found</h2>");
		echo("<h3>If you want to register a consult, please enter the following data</h3>");
		echo("<form action='new_consult.php' method='post'>
				<p><input type=hidden name='VAT_client'
			value='$VAT_client'/></p>
				<p><input type=hidden name='animal_name'
			value='$animal_name'/></p>
				<p>Date(Y-M-D): <input type='text' name='date_timestamp'/></p>				
				<p>S: <input type='text' name='S'/></p>
				<p>O: <input type='text' name='O'/></p>
				<p>A: <input type='text' name='A'/></p>
				<p>P: <input type='text' name='P'/></p>
				<p>VAT_Owner: <input type='text' name='VAT_owner'/></p>
				<p>VAT_Veterinary: <input type='text' name='VAT_vet'/></p>
				<p>Weight: <input type='text' name='weight'/></p>
				<p>Diagnostic codes: <input type='text' name='code'/></p>

				<p><small><u>NOTE:</u> Name and VAT owner were used the data previously entered.</small></p>		
				<p><input type='submit' value='SUBMIT'/></p>
			</form>");
	}
	else
	{	
		echo("<h3>Previous consults involved the animal '$animal_name', whose VAT client is '$VAT_client'</h3>");
		echo("<table border=\"2\">");
		echo("<tr><td>Animal Name</td><td>Date</td><td>Consult details</td></tr>");
		foreach($result as $row)
		{	
			echo("<tr>\n");
			echo("<td>{$row['name']}</td>\n");
			echo("<td>{$row['date_timestamp']}</td>\n");
			echo("<td><a href=\"consult_details.php?VAT_client=$VAT_client&animal_name=$animal_name&date_timestamp={$row['date_timestamp']}");
			echo("\">More information</a></td>\n");
			echo("</tr>\n");
		}

		echo("</table>");
		echo("<h3>If you want to register a consult, please enter the following data</h3>");
		echo("<form action='new_consult.php' method='post'>
				<p><input type=hidden name='VAT_client'
			value='$VAT_client'/></p>
				<p><input type=hidden name='animal_name'
			value='$animal_name'/></p>
				<p>Date(Y-M-D): <input type='text' name='date_timestamp'/></p>				
				<p>S: <input type='text' name='S'/></p>
				<p>O: <input type='text' name='O'/></p>
				<p>A: <input type='text' name='A'/></p>
				<p>P: <input type='text' name='P'/></p>
				<p>VAT_Owner: <input type='text' name='VAT_owner'/></p>
				<p>VAT_Veterinary: <input type='text' name='VAT_vet'/></p>
				<p>Weight: <input type='text' name='weight'/></p>
				<p>Diagnostic codes: <input type='text' name='code'/></p>

				<p><small><u>NOTE:</u> Name and VAT owner were used the data previously entered.</small></p>		
				<p><input type='submit' value='SUBMIT'/></p>
			</form>");
	}
	$connection = null;
	?>
</body>
</html>