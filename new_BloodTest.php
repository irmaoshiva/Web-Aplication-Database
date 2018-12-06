<html>
<body>
	<?php
		$VAT_client = $_REQUEST['VAT_client'];
		$VAT_owner = $_REQUEST['VAT_owner'];
		$name = $_REQUEST['animal_name'];
		$date_timestamp = $_REQUEST['date_timestamp'];
		$VAT_assistant = $_REQUEST['VAT_assistant'];
		$creatine = (float)$_REQUEST['creatine'];
		$Neurotrophils = (float)$_REQUEST['neuro'];
		$Lymphocytes = (float)$_REQUEST['lym'];
		$Monocytes = (float)$_REQUEST['mono'];
		$Ferritine = (float)$_REQUEST['ferr'];
		$description = $_REQUEST['desc'];
		if ($creatine > 0.0 && $Neurotrophils > 0.0 && $Lymphocytes > 0.0 && $Monocytes > 0.0 && $Ferritine > 0.0)
		{
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
			$sql = "SELECT MAX(num) FROM procedures";
			$result = $connection->query($sql)->fetch();
			$num = $result['MAX(num)'] + 1;
			
			$stm1 = "INSERT INTO procedures VALUES (:name, :VAT_owner, :date_timestamp, :num, :description)";
			$stm2 = "INSERT INTO test_procedure VALUES (:name, :VAT_owner, :date_timestamp, :num, :type)";
			$stm3 = "INSERT INTO performed VALUES (:name, :VAT_owner, :date_timestamp, :num, :VAT_assistant)";
			$stm4 = "INSERT INTO produced_indicator VALUES (:name, :VAT_owner, :date_timestamp, :num, :indicator_name, :value);";
			
			$sql1 = array(':name' => $name, ':VAT_owner' => $VAT_owner, ':date_timestamp' => $date_timestamp, ':num' => $num, ':description' => $description);
			$sql2 = array(':name' => $name, ':VAT_owner' => $VAT_owner, ':date_timestamp' => $date_timestamp, ':num' => $num, ':type' => 'Blood');
			$sql3 = array(':name' => $name, ':VAT_owner' => $VAT_owner, ':date_timestamp' => $date_timestamp, ':num' => $num, ':VAT_assistant' => $VAT_assistant);
			$sql4 = array(':name' => $name, ':VAT_owner' => $VAT_owner, ':date_timestamp' => $date_timestamp, ':num' => $num, ':indicator_name' => 'creatine level', ':value' => $creatine);
			$sql5 = array(':name' => $name, ':VAT_owner' => $VAT_owner, ':date_timestamp' => $date_timestamp, ':num' => $num, ':indicator_name' => 'Neurotrophils', ':value' => $Neurotrophils);
			$sql6 = array(':name' => $name, ':VAT_owner' => $VAT_owner, ':date_timestamp' => $date_timestamp, ':num' => $num, ':indicator_name' => 'Lymphocytes', ':value' => $Lymphocytes);
			$sql7 = array(':name' => $name, ':VAT_owner' => $VAT_owner, ':date_timestamp' => $date_timestamp, ':num' => $num, ':indicator_name' => 'Monocytes', ':value' => $creatine);
			$sql8 = array(':name' => $name, ':VAT_owner' => $VAT_owner, ':date_timestamp' => $date_timestamp, ':num' => $num, ':indicator_name' => 'Ferritin', ':value' => $Ferritine);
			
			$stm = array($stm4, $stm4, $stm4, $stm4, $stm4, $stm3, $stm2, $stm1);
			$sql = array($sql8, $sql7, $sql6, $sql5, $sql4, $sql3, $sql2, $sql1);
			$counter = count($sql);
			$connection->beginTransaction();
			while ($counter != 0)
				if (! $connection->prepare($stm[-- $counter])->execute($sql[$counter]))
					break;
			if ($counter == 0){
				$connection->commit();
				echo ("<p><h1> Insertion performed successfully! </h1> </p>");
			} else{
				$connection->rollback();
				//$info = $connection->errorInfo();
				//echo("<p>Error: {$info[2]}</p>");
				echo("<p><h1> Insertion failed <h1/></p>");
			}
			$connection = null;
		}
		else
			echo("<p>All measurements must be a positive value.</p>");
	?>

	<form action='procedures.php' method='post'>
		<h3>Insert new Blood test</h3>
		<p><input type=hidden name='VAT_owner' value = '<?=$VAT_owner?>' /></p>
		<p><input type=hidden name='animal_name' value = '<?=$name?>' /></p>
		<p><input type=hidden name='date_timestamp' value = '<?=$date_timestamp?>' /></p>
		<p>  <input type='submit' value='New' required/></p>
	</form>

	<br> </br>

	<form action='consults.php' method='post'>
		<h3>See your previous consults</h3>
		<p><input type=hidden name='VAT_client' value='<?=$VAT_client?>'/></p>
		<p><input type=hidden name='VAT_owner' value='<?=$VAT_owner?>'/></p>
		<p><input type=hidden name='animal_name' value='<?=$name?>'/></p>
		<p><input type='submit' value='BACK'/></p>
	</form>
	<br> </br>
	<form action='introduce_data.php' method='post'>
		<h3>Go back to Homepage</h3>
		<p><input type='submit' value='HOME'/></p>
	</form>

</body>
</html>
