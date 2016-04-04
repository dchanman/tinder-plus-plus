<?php
include 'credentials.php';
include 'verify.php';

?>

<html>
 	<head>
  		<title>Tinder++</title>
		<?php include 'head-includes.php';?>
		<script src="assets/js/custom.js"></script>
    	<link href="assets/css/custom.css" rel="stylesheet">
	</head>
 	<body>
		<?php include 'menu.php';?>
		<div class="maincontent">
			<div class="container">
				<h1>Tinder++ Interest Analytics</h1><br>
			</div>
			<div id="stats">
				<div class="container">
					<form method="POST" action="interest-stats.php" class="form-inline">
						<strong>Location:</strong><br>
						<select name="location_text" class="form-control" value="Update Location">
							<?php 
								$locations = query_getLocations();
								foreach($locations as $loc) {
									echo "<option value='$loc'>$loc</option>";
								}
							?>
							<option selected=selected></option>
						</select><br><br>
						<input class="btn btn-info" type="submit" name="mostPopularInterestTypeAtLocation" value="Most Popular Interest">
						<input class="btn btn-info" type="submit" name="leastPopularInterestTypeAtLocation" value="Least Popular Interest">
					</form>
				</div>
				<div class="container">
					<?php
						if ($db_conn) {
														
								if (array_key_exists('mostPopularInterestTypeAtLocation', $_POST)) {
									if ($_POST['location_text'] == ""){
										echo "Please select a location!";
										OCILogoff($db_conn);
										return;
									}

									$interests = mostPopularInterestTypeAtLocation($_POST['location_text']);

									echo "<h3>".$_POST['location_text']."'s Most Popular Interests</h3>";
									foreach ($interests as $int) {
										echo "$int<br>";
									}
									
								} else if (array_key_exists('leastPopularInterestTypeAtLocation', $_POST)) {
									if ($_POST['location_text'] == ""){
										echo "Please select a location!";
										OCILogoff($db_conn);
										return;
									}
									$interests = leastPopularInterestTypeAtLocation($_POST['location_text']);

									echo "<h3>".$_POST['location_text']."'s Least Popular Interests</h3>";
									foreach ($interests as $int) {
										echo "$int<br>";
									}
								}
								

							/* LOG OFF WHEN YOU'RE DONE! */
							OCILogoff($db_conn);

							} else { /* if ($db_conn) */
							echo "cannot connect";
							$e = OCI_Error(); // For OCILogon errors pass no handle
							echo htmlentities($e['message']);
						}
					?>
				</div>
			</div>
		</div>
    </body>
</html>



