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
	$VAT_owner = $_REQUEST['VAT_owner'];
	$curent_date = date('Y-m-d H:i:s');

	$stmt1 = $connection->prepare("SELECT p.name AS o_name, a.name AS a_name, c.VAT_owner AS VAT_o, date_timestamp
								   FROM (person p INNER JOIN animal a ON (p.VAT = a.VAT)) INNER JOIN consult c ON (a.name = c.name)
								   WHERE a.VAT = c.VAT_owner
								   AND a.name = :animal_name
								   AND c.VAT_owner = :VAT_owner");
	if ($stmt1 == FALSE)
	{
		$info = $connection->errorInfo();				
		echo('<p>Error: {$info[2]}</p>');
		exit();
	}
	$stmt1->execute(array(':animal_name' => $animal_name, 
						  ':VAT_owner' => $VAT_owner));

	$nrows1 = $stmt1->rowCount();

	if ($nrows1 == 0)
	{
		echo("<h2>Previous Consults Not Found</h2>");
	}
	else
	{	
		echo("<h3>Previous consults involving the animal $animal_name</h3>");
		echo("<table border=\"2\">");
		echo("<tr><td>Owner Name</td><td>Animal Name</td><td>VAT Owner</td><td>Date</td><td>Consult Details</td><td>Insert Procedure</td></tr>");
		
		foreach($stmt1 as $row)
		{	
			echo("<tr>\n");
			echo("<td>{$row['o_name']}</td>\n");
			echo("<td>{$row['a_name']}</td>\n");
			echo("<td>{$row['VAT_o']}</td>\n");
			echo("<td>{$row['date_timestamp']}</td>\n");
			echo("<td><a href=\"consult_details.php?VAT_client=$VAT_client&animal_name=$animal_name&VAT_owner=$VAT_owner&date_timestamp=");
			echo($row['date_timestamp']);
			echo("\">More information</a></td>\n");
			echo("<td><a href=\"procedures.php?VAT_owner=$VAT_client&animal_name=$animal_name&date_timestamp=");
			echo($row['VAT_o']);
			echo("&animal_name=$animal_name&date_timestamp=");
			echo($row['date_timestamp']);
			echo("\">New blood test</a></td>\n");
			echo("</tr>\n");
		}
		echo("</table>");
	}

	?>

	<br> </br>
	<h3>If you want to register a new consult, please enter the following data</h3>
	<form action='new_consult.php' method='post'>
		<p><input type='hidden' name='animal_name' value='<?=$animal_name?>'/></p>
		<p><input type='hidden' name='VAT_owner' value='<?=$VAT_owner?>'/></p>
		<p><input type='hidden' name='date_timestamp' value='<?=$curent_date?>'/></p>
		<p>S: <input type='text' name='s'/></p>
		<p>O: <input type='text' name='o'/></p>
		<p>A: <input type='text' name='a'/></p>
		<p>P: <input type='text' name='p'/></p>
		<p><input type='hidden' name='VAT_client' value='<?=$VAT_client?>'/></p>
		<p>VAT Veterinary:
			<select name='VAT_vet'>
				<?php
				$stmt2 = "SELECT VAT FROM veterinary ORDER BY VAT";
				$result2 = $connection->query($stmt2);
				if ($result2 == FALSE)
				{
					$info = $connection->errorInfo();
					echo('<p>Error: {$info[2]}</p>');
					exit();
				}
				foreach($result2 as $row)
				{
					$VAT_vet = $row['VAT'];
					echo("<option value=\"$VAT_vet\">$VAT_vet</option>");
				}
				?>
			</select>
		</p>
		<p>Weight: <input type="number" min="0" name='weight' required/></p>
		<p>Consult Diagnosis:
			<select name='code'>
				<?php
				$stmt3 = "SELECT code FROM diagnosis_code ORDER BY code";
				$result3 = $connection->query($stmt3);
				if ($result3 == FALSE)
				{
					$info = $connection->errorInfo();
					echo('<p>Error: {$info[2]}</p>');
					exit();
				}
				foreach($result3 as $row)
				{
					$code = $row['code'];
					echo("<option value=\"$code\">$code</option>");
				}
				?>
			</select>
		</p>

		<p><small><u>NOTE:</u> Animal name, VAT owner and VAT client were used the data previously entered. Date is set to the current date.</small></p>		
		<p><input type='submit' value='SUBMIT'/></p>
	</form>

	<?php
	$connection = null;
	?>
	<br> </br>
	<form action='introduce_data.php' method='post'>
		<h3>Go back to Homepage</h3>
		<p><input type='submit' value='HOME'/></p>
	</form>
</body>
</html>
