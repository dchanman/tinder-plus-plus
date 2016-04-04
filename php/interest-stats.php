<?php
include 'credentials.php';
include 'verify.php';

?>

<?php

  if ($db_conn) {	
	//need to get locations here, can't query after logoff
	$locations = query_getLocations();

   	if (array_key_exists('updateLocation', $_POST)) {
	// fill in shit here
		$mostPopularInterst = mostPopularInterestTypeAtLocation($_POST['location_text']);
	}

    /* LOG OFF WHEN YOU'RE DONE! */
    OCILogoff($db_conn);

  } else { /* if ($db_conn) */
    echo "cannot connect";
    $e = OCI_Error(); // For OCILogon errors pass no handle
    echo htmlentities($e['message']);
  }
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
				<h1>Tinder++ Interest Stats</h1><br>
				<p>Most popular interests by region</p>
			</div>
			<div id="stats">
				<div class="container">
					<form method="POST" action="interest-stats.php" class="form-inline">
						<strong>Location:</strong><br>
						<select name="location_text" class="form-control" value="Update Location">
							<?php 
								foreach($locations as $loc) {
									echo "<option value='$loc'>$loc</option>";
								}
							?>
							<option selected=selected></option>
						</select><br><br>
						<input class="btn btn-info" type="submit" name="updateLocation">
					</form>
				</div>
				<div class="container">
					<h3 class="col-xs-6">Most Popular Interest Type:</h3>
					<h3 class="col-xs-6"> <?php echo $mostPopularInterst;?> </h3>
				</div>
			</div>
		</div>
    </body>
</html>


