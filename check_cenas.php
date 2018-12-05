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

	$stmt1 = $connection->prepare("SELECT VAT 
								   FROM client 
								   WHERE VAT = :VAT_client");
	if ($stmt1 == FALSE)
	{
		$info = $connection->errorInfo();				
		echo('<p>Error: {$info[2]}</p>');
		exit();
	}
	$stmt1->execute(array(':VAT_client' => $VAT_client));

	$nrows1 = $stmt1->rowCount();

	if($nrows1)
	{
		$stmt2 = $connection->prepare("SELECT p.name AS o_name, a.name AS a_name, colour, gender, birth_year, age 
				 					   FROM person p INNER JOIN animal a ON (p.VAT = a.VAT) 
				 					   WHERE a.name = :animal_name 
				 					   AND p.name like CONCAT('%',:owner_name,'%')");
		if ($stmt2 == FALSE)
		{
			$info = $connection->errorInfo();				
			echo('<p>Error: {$info[2]}</p>');
			exit();
		}
		$stmt2->execute(array(':animal_name' => $animal_name, ':owner_name' => $owner_name));

		$nrows2 = $stmt2->rowCount();

		if ($nrows2 == 0)
		{	
			?>
			<form action='new_animal.php' method='post'>
				<h2>Animal Not Found</h2>
				<h3>If you want to register the animal in the veterinary hospital, please enter the following data:</h3>
				<p><input type=hidden name='VAT' value='<?=$VAT_client?>'/></p>
				<p><input type=hidden name='animal_name' value='<?=$animal_name?>'/></p>
				<p>Species Name:
					<select name='species_name'>
						<?php
						$stmt3 = "SELECT name AS species_name FROM species ORDER BY name";
						$result3 = $connection->query($stmt3);
						if ($result3 == FALSE)
						{
							$info = $connection->errorInfo();
							echo('<p>Error: {$info[2]}</p>');
							exit();
						}
						foreach($result3 as $row)
						{
							$species_name = $row['species_name'];
							echo("<option value=\"$species_name\">$species_name</option>");
						}
						?>
					</select>
				</p>
				<p>Colour: <input type='text' name='colour' required/></p>
				<p>Gender: <input type='text' name='gender' required/></p>
				<p>Birth Year: <input type='date' name='birth_year' required/></p>
				<p><small><u>NOTE:</u> Name and VAT owner were already used in the data previously entered. Age is automatically calculated.</small></p>		
				<p><input type='submit' value='SUBMIT'/></p>
			</form>
			<?php
		}
		else
		{	
			echo("<h2>Animal is already registered</h2>");
			echo("<h3>Matching Animals</h3>");
			echo("<table border=\"2\">");
			echo("<tr><td>Owner Name</td><td>Animal Name</td><td>Colour</td><td>Gender</td><td>Birth Year</td><td>Age</td><td>Previous consults involved the animal</td></tr>");
			foreach($stmt2 as $row)
			{
				echo("<tr>\n");
				echo("<td>{$row['o_name']}</td>\n");
				echo("<td>{$row['a_name']}</td>\n");
				echo("<td>{$row['colour']}</td>\n");
				echo("<td>{$row['gender']}</td>\n");
				echo("<td>{$row['birth_year']}</td>\n");
				echo("<td>{$row['age']}</td>\n");
				echo("<td><a href=\"consults.php?VAT_client=$VAT_client&animal_name=$animal_name"); /*nova versão (2 inputs) */ 
				/*echo("<td><a href=\"consults.php?VAT_client="); versão antiga */
				/*echo($VAT_client);  versão antiga */
				echo("\">ConsultsHistory/AddConsult</a></td>\n");
				echo("</tr>\n");
			}
			echo("</table>");
		}
	}
	else
	{
		echo("<h2>Client Not Found</h2>");
		echo("<p>Please insert manually through the MySQL command line prompt the information of the new Client</p>");
	}

	$connection = null;
	?>
	<br> </br>
	<form action='introduce_data.php' method='post'>
		<h3>Go back to Homepage</h3>
		<p><input type='submit' value='HOME'/></p>
	</form>
</body>
</html>
