<html>
<body>
	<?php
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

			$sql = "SELECT MAX(num) FROM procedures";
			$result = $connection->query($sql)->fetch();
			$num = $result['MAX(num)'] + 1;

			$sql1 = "INSERT INTO procedures VALUES ('$name', $VAT_owner,'$date_timestamp', $num, '$description')";
			$sql2 = "INSERT INTO test_procedure VALUES ('$name', $VAT_owner, '$date_timestamp', $num, 'Blood')";
			$sql3 = "INSERT INTO performed VALUES ('$name','$VAT_owner','$date_timestamp','$num', '$VAT_assistant')";
			$sql4 = "INSERT INTO produced_indicator VALUES ('$name', $VAT_owner, '$date_timestamp', $num, 'creatine level', $creatine)";
			$sql5 = "INSERT INTO produced_indicator VALUES ('$name', $VAT_owner, '$date_timestamp', $num, 'Neurotrophils', $Neurotrophils)";
			$sql6 = "INSERT INTO produced_indicator VALUES ('$name', $VAT_owner, '$date_timestamp', $num, 'Lymphocytes', $Lymphocytes)";
			$sql7 = "INSERT INTO produced_indicator VALUES ('$name', $VAT_owner, '$date_timestamp', $num, 'Monocytes', $Monocytes)";
			$sql8 = "INSERT INTO produced_indicator VALUES ('$name', $VAT_owner, '$date_timestamp', $num, 'Ferritin', $Ferritine)";

			$sql_ = array($sql1, $sql2, $sql3, $sql4, $sql5, $sql6, $sql7, $sql8);
			$counter = count($sql_);

			$connection->beginTransaction();

			foreach($sql_ as &$sql){
				echo "<p>$sql</p>";
				echo "<p>$counter</p>";
				if (! $connection->exec($sql))
					break;
				else
					$counter--;
			}			

			if ($counter == 0){
				$connection->commit();
				echo ("<p> Insertion performed successfully! </p>");
			} else{
				$connection->rollback();
				echo("<p>Insertion failed</p>");
			}

		
			$connection = null;
		}
		else
			echo("<p>All measurements must be a positive value.</p>");
	?>
</body>
</html>
