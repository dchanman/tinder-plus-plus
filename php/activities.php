<?php
include 'credentials.php';
include 'verify.php';
?>

<html>
 	<head>
  		<title>Tinder++</title>
		<?php include 'head-includes.php'?>
		<script src="assets/js/custom.js"></script>
    	<link href="assets/css/custom.css" rel="stylesheet">
	</head>
 	<body>
		<?php include 'menu.php';?>
		<div class="maincontent">
			<div class="container">
				<h1>Tinder++ Activities</h1><br>
				<p>Browse the discounts on the different activities available! (and score on awesome discounts too)</p>
			</div>
			<div id="Activities">
				<div class="container">
					Filter by interest:
					<form method="POST" action="activities.php" class="form-inline">
							<?php

								echo '<h4><b>Interests: </b></h4>';
								$interests = query_getInterests();

								foreach ($interests as $int) {
								/* The following echos all print a single line for the checkbox and label. This is hacky as hell. Sorry guys */

								/* We want a checkbox */
								echo '<input type="checkbox" ';
								/* The variable name of the checkbox depends on the interest name */
								echo 'name="'.$int.'_checkbox" ';
								/* We want to check the box automatically if the user already set this interest */
								echo (in_array($int, $userInterests) === FALSE ? '' : 'checked').'>';
								/* Print the text label for the checkbox */
								echo " $int <br>";
							}
							?>
							<input type="submit" class="btn btn-info">
					</form>
				</div>
			</div>
		</div>
    </body>
</html>
