	<?php
		// Initialize the session
		session_start();
		
		// Check if user is not logged in, if not redirect to the login page. 
		if($_SESSION["loggedin"] != true){
			$_SESSION['message'] = 'message';
			header("location: /login.php");
			exit;
		}
		// Include Config
		//require_once "config.php";
		
	?>

	<?php
		
		function update_elevatorNetwork(int $node_ID, int $status): int {
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

		function insert_elevatorNetwork_webreq(int $node_ID, int $stat, int $floor): int {
			try { $db = new PDO('mysql:host=127.0.0.1;dbname=elevator','ese','ese');}
			catch (PDOException $e){echo $e->getMessage();}

			$query = 'INSERT INTO elevatorNetwork (nodeID, status, floor)
					VALUES (:node, :status, :floor )';
			$statement = $db1->prepare($query);
			$statement->bindvalue('id', $node_ID);
			$statement->bindvalue('status', $stat);
			$statement->bindvalue('floor', $new_floor);
			
			$statement->execute();	
			echo "sucsess";
			return $new_floor;
		}

	?>
	<?php 
		/* Old get floor function
		function get_currentFloor(): int {
			try { $db = new PDO('mysql:host=127.0.0.1;dbname=elevator','ese','ese');}
			catch (PDOException $e){echo $e->getMessage();}

				// Query the database to display current floor
				$rows = $db->query('SELECT currentFloor FROM elevatorNetwork');
				foreach ($rows as $row) {
					$current_floor = $row[0];
				}
				return $current_floor;
		}*/

		function get_Floor(): int {
			try { $db = new PDO('mysql:host=127.0.0.1;dbname=elevator','ese','ese');}
			catch (PDOException $e){echo $e->getMessage();}

				// Query the database to display current floor
				$rows = $db->query('SELECT floor FROM elevatorNetwork WHERE status = 2');
				foreach ($rows as $row) {
					$requested_floor = $row[0];
				}
				return $requested_floor;
		}

		function get_move_Floor(): int {
			try { $db = new PDO('mysql:host=127.0.0.1;dbname=elevator','ese','ese');}
			catch (PDOException $e){echo $e->getMessage();}

				// Query the database to display current floor
				$rows = $db->query('SELECT floor FROM elevatorNetwork WHERE status = 1'); // Recieves the direction of the elevator moving. 
				foreach ($rows as $row) {
					$requested_floor = $row[0];
				}
				return $requested_floor;
		}
	?>

	<!DOCTYPE html>
	<html>
		<head>
			<link href='/css/gui.css' type='text/css' rel='stylesheet'/> 
			<link href='/css/menu.css' type='text/css' rel='stylesheet'/> 
			<title>Graphical User Interface</title>
			<script src="gui.js" type="text/javascript"></script>
		</head>

		<body>
		
			<div class='div1'>
				<ul class='h_menu'>
					<li class='index'><a class='menu' href="/menu.html"><b>Main Menu</b></a></li>
					<li class='gui'><a class='menu' href="/gui/gui.php"><b>Elevator Control</b></a></li>
					<li class='about'><a class='menu' href="/about.html"><b>About the team</b></a></li>
					<li class='project'><a class='menu' href="/projectplan.html"><b>Project Plan</b></a></li>
					<li class='video'><a class='menu' href="/video.html"><b>Video Demonstration</b></a></li>
					<li class='logout'><a class='menu' href="/logout.php"><b>Logout</b></a></li>
					<li class='login'><a class='menu' href="/login.php"><b>login</b></a></li>
				</ul class='h_menu'>
			</div>

			<?php 
				//$flr = get_Floor();
				//$move = get_move_Floor();
				
				/*if(isset($_GET['id'])) {
					if($_GET['value'] =="1" || $_GET['value'] =="2" || $_GET['value'] =="3"){
						$curFlr = update_elevatorNetwork(0, $_GET['value']); 
						header('Refresh:0; url=gui.php');
					}
				}*/
				

				/*if($flr == 1 || $move==5){
					echo "<img src='img/Indicator_1_up.png' class='indc_NO' id='floor'>";
				}
				else if($flr == 1 || $move==4){
					echo "<img src='img/Indicator_1_down.png' class='indc_NO' id='floor'>";
				}
				else if($flr == 2 || $move==5){
					echo "<img src='img/Indicator_2_up.png' class='indc_NO' id='floor'>";
				}
				else if($flr == 2 || $move==4){
					echo "<img src='img/Indicator_2_down.png' class='indc_NO' id='floor'>";
				}
				else if($flr == 3 || $move==5){
					echo "<img src='img/Indicator_3_up.png' class='indc_NO' id='floor'>";
				}
				else if($flr == 3 || $move==4){
					echo "<img src='img/Indicator_3_down.png' class='indc_NO' id='floor'>";
				}
				else{
					echo "<img src='img/Indicator_No_Floor.png' class='indc_NO' id='floor'>";
				}*/
						
				echo "<h2>Current floor # $curFlr </h2>";
				if(isset($_GET['id'])){
					if($_GET['id']=='I'){
						switch($_GET['value']){
							case "1":
								echo "Floor 1 Button has been un-pressed";
								break;
							case "2":
								echo "Floor 2 Button has been un-pressed";
								break;
							case "3":
								echo "Floor 3 Button has been un-pressed";
								break;
							case "C":
								echo "Closed door Button has been un-pressed";
								break;
							case "O":
								echo "Open door Button has been un-pressed";
								break;
							case "F":
								echo "Fan Button has been un-pressed";
								break;
							case "B":
								echo "Bell Button has been un-pressed";
								break;
							case "11":
								echo "Floor 1 Button has been pressed";
								$insert = insert_elevatorNetwork_webreq(0, 0, 1); 
								header('Refresh:0; url=gui.php');
								break;
							case "21":
								echo "Floor 2 Button has been pressed";
								$insert = insert_elevatorNetwork_webreq(0, 0, 2); 
								header('Refresh:0; url=gui.php');
								break;
							case "31":
								echo "Floor 3 Button has been pressed";
								$insert = insert_elevatorNetwork_webreq(0, 0, 3); 
								header('Refresh:0; url=gui.php');
								break;
							case "C1":
								echo "Closed door Button has been pressed";
								break;
							case "O1":
								echo "Open door Button has been pressed";
								break;
							case "F1":
								echo "Fan Button has been pressed";
								break;
							case "B1":
								echo "Bell Button has been pressed";
								break;
							default:
								echo "";
								
						}
					}
				}
				if(!isset($_GET['id'])){
					$oneStat= $U2Stat = $D2Stat = $threeStat = 0;
				}
				if(isset($_GET['id'])){
					if($_GET['id']=='D'){
						switch($_GET['value']){
							case "1":
								echo "1 Calling To go Up";
								$insert = insert_elevatorNetwork_webreq(0, 1, 5); 
								
								if($oneStat == 0){
									audio(1);
									$oneStat = 1;
								}
								else{
									$oneStat = 0;
								}
								
								break;
							case "2U":
								echo "2 Calling To go Up";
								$insert = insert_elevatorNetwork_webreq(0, 2, 5); 
								
								if($U2Stat == 0){
									audio(1);
									$U2Stat = 1;
								}
								else{
									$U2Stat = 0;
								}
								break;
							case "2D":
								echo "2 Calling To go Down";
								$insert = insert_elevatorNetwork_webreq(0, 2, 4); 
								
								if($D2Stat == 0){
									audio(2);
									$D2Stat = 1;
								}
								else{
									$D2Stat = 0;
								}
								break;
							case "3":
								echo "3 Calling To go Down";
								$insert = insert_elevatorNetwork_webreq(0, 3, 4); 
								header('Refresh:0; url=gui.php');
								if($threeStat == 0){
									audio(2);
									$threeStat = 1;
								}
								else{
									$threeStat = 0;
								}
								break;
							default:
								echo "";
						}
					}

					//header('Refresh:0; url=gui.php');
				}
			
			function audio(int $flag){
                if($flag == 1){
					echo "<script> 
					var audio = new Audio('./audio/up.mp3');
 					audio.play();
 					</script>";
				}
				if($flag == 2){
					echo "<script>
					var audio = new Audio('./audio/down.mp3');
					audio.play();
					</script>";
            	}
			}

			?>		
			
			<h2> 	
			<form action=gui.php method="GET">

					<img src="img/none_lit_up.png" class="I_NO" usemap="#I" id="INO">
					<map name="I">
						<area shape="circle" coords="125, 73, 30" onclick="myFunction_I3()" href="gui.php?id=I&value=31">
						<area shape="circle" coords="125, 157, 30" onclick="myFunction_I2()" href="gui.php?id=I&value=21">
						<area shape="circle" coords="125, 240, 30" onclick=" myFunction_I1()" href="gui.php?id=I&value=11">
						<area shape="circle" coords="78, 320,30" onclick="myFunction_IO()" href="gui.php?id=I&value=O1">
						<area shape="circle" coords="174, 320,30" onclick="myFunction_IC()" href="gui.php?id=I&value=C1">
						<area shape="circle" coords="78, 403, 30" onclick="myFunction_IF()" href="gui.php?id=I&value=F1">
						<area shape="circle" coords="174, 403, 30" onclick="myFunction_IB()" href="gui.php?id=I&value=B1">
					</map>
			
					<a href="gui.php?id=I&value=B"><img src="img/panel/alarm_lit_up.png" class="mapA" id="A" onclick="myFunction_IB()"></a>
					<a href="gui.php?id=I&value=1"><img src="img/panel/button_1_lit_up.png" class="map1" id="one" onclick=" myFunction_I1()"></a>
					<a href="gui.php?id=I&value=2"><img src="img/panel/button_2_lit_up.png" class="map2" id="two" onclick="myFunction_I2()"></a>
					<a href="gui.php?id=I&value=3"><img src="img/panel/button_3_lit_up.png" class="map3" id="three" onclick="myFunction_I3()"></a>
					<a href="gui.php?id=I&value=C"><img src="img/panel/close_light_up.png" class="mapC" id="C" onclick="myFunction_IC()"></a>
					<a href="gui.php?id=I&value=F"><img src="img/panel/fan_lit_up.png" class="mapF" id="F" onclick="myFunction_IF()"></a>
					<a href="gui.php?id=I&value=O"><img src="img/panel/open_lit_up.png" class="mapO" id="O" onclick="myFunction_IO()"></a>

	
					<h1 class="floor3">Floor 3</h1>
					<img src="img/CallButtonDown.png" class="C_D" usemap="#CD" id="CD">
					<map name="CD">
						<area shape="circle" coords="63, 117,36" onclick="myFunction_CD()" href="gui.php?id=D&value=3">
						
					</map>

					<h1 class="floor2">Floor 2</h1>
					<img src="img/CallButtonUpDown.png" class="C_UD" usemap="#CUD" id="CUD">
					<map name="CUD">
						<area shape="circle" coords="63, 64,36" onclick="myFunction_CUD_U()" href="gui.php?id=D&value=2U">
						<area shape="circle" coords="63, 169,36" onclick="myFunction_CUD_D()" href="gui.php?id=D&value=2D">
					</map>

					<h1 class="floor1">Floor 1</h1>
					<img src="img/CallButtonUp.png" class="C_U" usemap="#CU" id="CU">
					<map name="CU">
						<area shape="circle" coords="63, 117,36" onclick="myFunction_CU()" href="gui.php?id=D&value=1">
					</map>
					<?php //<iframe class='stream' src="http://192.168.0.201:5080/" ></iframe>?>

					<script type="text/javascript">
						imginit();
					</script>

					<audio id='down'>
						<source src="./audio/down.mp3">
					</audio>
					<audio id='up'>
						<source src="./audio/up.mp3">
					</audio>
					<audio id='first'>
						<source src="./audio/first.mp3">
					</audio>
					<audio id='second'>
						<source src="./audio/second.mp3">
					</audio>
					<audio id='third'>
						<source src="./audio/third.mp3">
					</audio>

				</form>
			</h2> 
		</body>
			
	</html>
	
	

