<?php
include 'credentials.php';
include 'sql-cmds.php';
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
					<form method="POST" action="activities.php" class="form-inline">
							<h3><b>Choose your interests: </b></h3>
							<?php
								
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
							<h3><b>Choose what info you would like to see</b></h3>
							<input type="checkbox" name="businessName" checked>Business<br>
							<input type="checkbox" name="scheduledTime" checked>Scheduled Time<br>
							<input type="checkbox" name="interestType" checked>Interest<br>
							<input type="checkbox" name="discount" checked>Discount<br>
							<input type="submit" name="filterActivity" class="btn btn-info">
					</form>
				</div>
			</div>

			<div>
				<?php
					if ($db_conn) {

						/* Handle POSTs */
						if (array_key_exists('filterActivity', $_POST)) {

							/* Hacky way of creating our SQL query projection string */
							/* eg result: SELECT "activity, business, discount" FROM Activities... */
							$projection = "activity";
							$projection .= ($_POST['businessName'] ? ", businessName" : "");
							$projection .= ($_POST['scheduledTime'] ? ", scheduledTime" : "");
							$projection .= ($_POST['interestType'] ? ", interestType" : "");
							$projection .= ($_POST['discount'] ? ", discount" : "");

							/* Another hacky way of creating our SQL query selection string */
							/* eg result: ...WHERE interestType = 'Nightlife' OR interestType = 'Hiking' */
							$selection = "";
							$interests = query_getInterests();
							foreach ($interests as $int) {
								if ($_POST[$int.'_checkbox']) {
									/* We don't want to prepend "OR" for our first selection */
									if (strcmp($selection, "") != 0) {
										$selection .= " OR ";
									}
									$selection .= "interestType = '$int'";
								}
							}


							/* Make sure our selection string is not empty */
							if (strcmp($selection, "") != 0) {
								echo "<h3>Recommended Dates</h3>";

								/* Run the query and output results */
								$results = query_getActivitiesSelectAndFilter($projection, $selection);

								foreach ($results as $activity) {
									echo "<div>";
									echo "<h4><b>" . $activity['activity'] ."</b></h4>";

									if ($activity['businessName'])
										echo "<b>"  . $activity['businessName'] ."</b><br>";

									if ($activity['interestType'])
										echo $activity['interestType'] ."<br>";

									if ($activity['scheduledTime'])
										echo $activity['scheduledTime'] ."<br>";

									if ($activity['discount'])
										echo $activity['discount'] ."% off<br>";

									echo "</div>";
								}

							} else {
								echo "<p>You must select at least one interest category!</p>";
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
    </body>
</html>

