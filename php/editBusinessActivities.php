<?php
include ('business_session.php');

ini_set('session.save_path', $cshomedir.'/public_html/php_sessions');
session_start();

$name = $_SESSION['login_business'];

if ($db_conn) {

	if (array_key_exists('editBusinessActivities', $_POST)) {

		/**
		 * How does this POST work? 
		 * Make sure you're sitting.
		 * 
		 * So when we created the list of fields per each array item, 
		 * each field came from an index in the Activities array.
		 *
		 * Now we appended the index number to each of the fields
		 * in all of the forms. For example, old_activity would be
		 * labelled as 'old_activity0' for element index 0.
		 *
		 * The index is set as the button's value, so it's stored in
		 * $_POST['editBusinessActivities']. We ake the index and append
		 * it to all of our fields. And we gud now.
		 *
		 * I'm sorry.
		 */
		$i = $_POST['editBusinessActivities'];
		
		$result = update_activity($name, $_POST['old_activity'.$i], $_POST['old_scheduledTime'.$i], $_POST['activity'.$i], $_POST['scheduledTime'.$i], $_POST['discount'.$i], $_POST['interestType'.$i]);

		echo $result;


		//update_businessProfile($business_id, $_POST['location_text']);

		/* Commit to save changes... */
		OCICommit($db_conn);
	}

} else { /* if ($db_conn) */
	echo "cannot connect";
	$e = OCI_Error(); // For OCILogon errors pass no handle
	echo htmlentities($e['message']);
}
?>

<html>
 	<head>
  		<title>Edit Profile</title>
		<?php include 'head-includes.php' ?>
	</head>
	<script>
		function backToProfile(){
			window.location = "business_profile.php";
		}
	</script>
 	<body>
		<?php include 'menu.php';?>
		<?php echo "<h1>Edit Activities ($name)</h1>"; ?>

		<?php

		/* Field for a new activity */
		echo "<h2>New Activity</h2>";
	    echo '<form method="POST" class="form-inline">';
  		echo '<label>Activity Name</label><input type="text" class="form-control" name="activity" size="30"><br>';
  		echo '<label>Discount</label><input type="text" class="form-control" name="discount" size="30"><br>';
  		
  		/* Print available times */
  		echo '<label>Time</label><select name="scheduledTime" class="form-control">';
  		$times = query_getScheduledTimes();
  		foreach($times as $time) {   			
			echo "<option value='$time'>$time</option>";
  		}
  		echo "</select>";

  		/* Print interests */
  		echo '<label>Interest Type</label><select name="interestType" class="form-control">';
  		$interests = query_getInterests();
  		foreach($interests as $int) {   			
			echo "<option value='$int'>$int</option>";
  		}
  		echo "</select>";
  		echo '<input type="submit" class="btn btn-default" value="Edit" action="editBusinessActivities.php" name="editBusinessActivities"><br>';

  		echo "<hr>";

		/* Print activities */
		echo "<h2>Your Activities</h2>";
		$activities = query_getActivitiesWithCompanyName($name);
		for ($i = 0; $i < count($activities); $i++) {
			/* We need some way of tracking the ids of the forms... This is the jankiest. This prevents concurrency from ever happening lol */
			$activity = $activities[$i];
			echo "<h3>" . $$activity['activity'] . "</h3>";
		    echo '<form method="POST" class="form-inline">';
		    /* We have to keep the old values in case we change them. These values are part of the key for Activity */
		    echo '<input type="hidden" name="old_activity'.$i.'" value="'. $activity['activity'] .'">';
		    echo '<input type="hidden" name="old_scheduledTime'.$i.'" value="'. $activity['scheduledTime'] .'">';

      		echo '<label>Activity Name</label><input type="text" class="form-control" name="activity'.$i.'" size="30" value="' . $activity['activity'] . '"><br>';
      		echo '<label>Discount</label><input type="text" class="form-control" name="discount'.$i.'" size="30" value="' . $activity['discount'] . '"><br>';
      		
      		/* Print available times */
      		echo '<label>Time</label><select name="scheduledTime'.$i.'" class="form-control">';
      		$times = query_getScheduledTimes();
      		foreach($times as $time) {   			
				/* We want to autoselect the current time */
				if (strcmp($activity['scheduledTime'], $time) == 0)
					echo "<option value='$time' selected=selected>$time</option>";
				else
					echo "<option value='$time'>$time</option>";
      		}
      		echo "</select>";

      		/* Print interests */
      		echo '<label>Interest Type</label><select name="interestType'.$i.'" class="form-control">';
      		$interests = query_getInterests();
      		foreach($interests as $int) {   			
				/* We want to autoselect the current interest */
				if (strcmp($activity['interestType'], $int) == 0)
					echo "<option value='$int' selected=selected>$int</option>";
				else
					echo "<option value='$int'>$int</option>";
      		}
      		echo "</select>";

      		echo '<button type="submit" class="btn btn-default" value="'.$i.'" action="editBusinessActivities.php" name="editBusinessActivities">Edit</button><br>';
		}

		echo "<hr>";

		/* LOG OFF WHEN YOU'RE DONE! */
		OCILogoff($db_conn);
		?>

		<input type="button" class="btn btn-default" value="Return to profile" onclick="backToProfile();">
		</body>
	</body>
</html>