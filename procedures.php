<?php
	$host = "db.ist.utl.pt";
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
	$VAT_owner = $_REQUEST['VAT_owner'];
	$animal_name = $_REQUEST['animal_name'];
	$date_timestamp = $_REQUEST['date_timestamp'];
	$sql = "SELECT VAT_assistant 
			FROM participation 
			WHERE name = '$animal_name' and VAT_owner = '$VAT_owner' and date_timestamp = '$date_timestamp'";

	$sql = "SELECT VAT_assistant 
			FROM participation 
			WHERE name = '$animal_name' and VAT_owner = '$VAT_owner' and date_timestamp = '$date_timestamp'";


	$rows = $connection->query($sql);
	$connection = null;
?>
	
<html>
<body>
	<h3>Insert the blood test results:</h3>
	
	<form action='new_BloodTest.php' method='post'>
			<p><input type=hidden name='VAT_owner' value = '<?=$VAT_owner?>' /></p>
			<p><input type=hidden name='anima_lname' value = '<?=$animal_name?>' /></p>
			<p><input type=hidden name='date_timestamp' value = '<?=$date_timestamp?>' /></p>

			<p>Assistants VAT:
				<select name="VAT_assistant">
					<?php
					foreach($rows as $row)
					{
						$vat = $row['VAT_assistant'];
						echo("<option value=\"$vat\">$vat</option>");
					}
					?>
				</select>
			</p>

			<p>Creatine level: <input type='text' name='creatine' required/></p>
			<p>Neurotrophils: <input type='text' name='neuro' required/></p>
			<p>Lymphocytes: <input type='text' name='lym' required/></p>
			<p>Monocytes: <input type='text' name='mono' required/></p>
			<p>Ferritine: <input type='text' name='ferr' required/></p>
			<p>Description: <input type='text' name='desc' required/></p>
			<p>  <input type='submit' value='SUBMIT' required/></p>
		</form>
	
</body>
</html>

