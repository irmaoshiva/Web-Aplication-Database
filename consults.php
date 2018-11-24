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
	$sql = "SELECT * FROM consult p WHERE p.VAT_client = '$VAT_client'";
	/*echo("<p>$sql</p>");*/
	$result = $connection->query($sql);
	$nrows = $result->rowCount();
	if ($nrows == 0)
	{
		echo("<h2>Previous Consults Not Found</h2>");
	}
	else
	{	
		echo("<h3>Previous consults involved the VAT for the client '$VAT_client'</h3>");
		echo("<table border=\"2\">");
		echo("<tr><td>Animal Name</td><td>VAT Owner</td><td>Date</td><td>Subjective Observation</td><td>Objective Observation</td><td>Assessment</td><td>Plan</td><td>VAT Client</td><td>VAT Veterinary</td><td>Weight</td></tr>");
		foreach($result as $row)
		{
			echo("<tr>\n");
			echo("<td>{$row['name']}</td>\n");
			echo("<td>{$row['VAT_owner']}</td>\n");
			echo("<td>{$row['date_timestamp']}</td>\n");
			echo("<td>{$row['s']}</td>\n");
			echo("<td>{$row['o']}</td>\n");
			echo("<td>{$row['a']}</td>\n");
			echo("<td>{$row['p']}</td>\n");
			echo("<td>{$row['VAT_client']}</td>\n");
			echo("<td>{$row['VAT_vet']}</td>\n");
			echo("<td>{$row['weight']}</td>\n");			
			echo("</tr>\n");
		}
		echo("</table>");
	}
	$connection = null;
	?>
</body>
</html>