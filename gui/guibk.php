<?php
	
	function update_elevatorNetwork(int $node_ID, int $new_floor =1): int {
		$db1 = new PDO('mysql:host=127.0.0.1;dbname=elevator','ese','ese');
		$query = 'UPDATE elevatorNetwork 
				SET requestedFloor = :floor
				WHERE nodeID = :id';
		$statement = $db1->prepare($query);
		$statement->bindvalue('floor', $new_floor);
		$statement->bindvalue('id', $node_ID);
		$statement->execute();	
		
		return $new_floor;
	}
?>
<?php 
	function get_currentFloor(): int {
		try { $db = new PDO('mysql:host=127.0.0.1;dbname=elevator','ese','ese');}
		catch (PDOException $e){echo $e->getMessage();}

			// Query the database to display current floor
			$rows = $db->query('SELECT currentFloor FROM elevatorNetwork');
			foreach ($rows as $row) {
				$current_floor = $row[0];
			}
			return $current_floor;
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<link href='css/gui.css' type='text/css' rel='stylesheet'/> 
		<title>Graphical User Interface</title>
	</head>

	<body>
	<h1>ESE Project VI Elevator GUI</h1> 
		<?php 
			// When the "GO" button is pressed, it sends the value of the new floor the user want to the elevator network. 
			// and it then refreshes the page and re-loads.
			if(isset($_POST['newfloor'])) {
				$curFlr = update_elevatorNetwork(1, $_POST['newfloor']); 
				header('Refresh:0; url=gui.php');	
			} 
			$curFlr = get_currentFloor();
			echo "<h2>Current floor # $curFlr </h2>";			
		?>		
		
		<h2> 	
			<form action="gui.php" method="POST">
				Request floor # <input type="number" style="width:50px; height:40px" name="newfloor" max=3 min=1 required />
				<input type="submit" value="Go"/>
			</form>
		</h2>

		<p><a href="/index.html"> Return </a></p>
		</body>
		
</html>
 
 
