<html>
 	<head>
  		<title>Welcome to Tinder++</title>
		<?php
			include 'head-includes.php';
		 	include 'credentials.php';
  			include 'sql-cmds.php';
  		?>
	</head>
 	<body>
		<?php include 'menu.php';?>
			<div class="maincontent container">
				<h1>Tinder++ Signup</h1><br>
				<form method="POST" action="newuser.php" class="form-inline">
					<input type="text" name="username_text" class="form-control" size="20" placeholder="Username"><br>
					<input type="text" name="name_text" class="form-control" size="20" placeholder="Name"><br>
					<input type="password" name="password_text" class="form-control" size="20" placeholder="Password"><br>
					<input type="password" name="confirm_password_text" class="form-control" size="20" placeholder="Confirm Password"><br>
					<input type="text" name="age_text" class="form-control" size="6" placeholder="Age"><br>
					<strong>Location:</strong><select name="location_text" class="form-control">';
					<?php 
						$locations = query_getLocations();
						foreach($locations as $loc) {
							echo "<option value='$loc'>$loc</option>";
						}
					?>
					<option selected=selected></option>
					</select><br>

					<strong>Gender:</strong> <br>
					<input type="radio" name="gender" value="m"> Male<br>
					<input type="radio" name="gender" value="f"> Female<br>
					<strong>Preference:</strong> <br>
					<strong>Men:</strong> <input type="checkbox" name="interestedInMen" value="m">
					<strong>Women:</strong> <input type="checkbox" name="interestedInWomen" value="f">
					
					<br>
					<input type="submit" value="Sign Up!" class="btn btn-success" name="signup">
				</form>
			</div>
	</body>
</html>

<?php

  if ($db_conn) {

   if (array_key_exists('signup', $_POST)) {
		

		if (!is_numeric($_POST['age_text'])) {
			echo "Please enter a valid age";
			printResult($result);
			return;
		} else if ($_POST['age_text'] < 19) {
			echo "Minimum age to use this platform is 19";
			printResult($result);
			return;
		}
		
		if($_POST['password_text'] == NULL) {
			echo "Password cannot be blank";
			return;
		}

		if($_POST['password_text'] != $_POST['confirm_password_text']){
			echo "Passwords don't match";
			printResult($result);
			return;
		}

		if ($_POST['location_text'] == NULL) {
			echo "Please specify your location";
			return;
		}

		if ($_POST['gender'] == NULL) {
			echo "Please indicate your gender!";
			return;
		}
		
		if ($_POST['interestedInMen'] == NULL && $_POST['interestedInWomen'] == NULL) {
			echo "Please indicate your preference!";
			return;
		}
		$_POST['preference'] = '';
		if ($_POST['interestedInMen'] != NULL) {
			$_POST['preference'] .= 'm';
		}

		if ($_POST['interestedInWomen'] != NULL){
			$_POST['preference'] .= 'f';
		}

		$_POST['password_hash'] = crypt($_POST['password_text']);
		//password_hash($_POST['password_text'], PASSWORD_DEFAULT);

		/* UserIDSequence.nextval automatically gets the next available user ID for us from the database */
		/* Note that if the insert fails, we still increment the sequence... lol */
		$resultArr = insert_addNewUser($_POST['username_text'], $_POST['name_text'], $_POST['location_text'], $_POST['age_text'], $_POST['gender'], $_POST['preference'], $_POST['password_text']);
		if ($resultArr["SUCCESS"] == 0) {
			if ($resultArr["ERRCODE"] == 1) {
				echo "Username already exists!";
			} else {
				echo "Uh oh, unrecognized error code: ";
				echo $resultArr['ERRCODE'];
			}
		} else {
			/* Made a new account successfully */

			/* Commit to database */
			OCICommit($db_conn);
    		OCILogoff($db_conn);

			/* Redirect to login page */
    		header("Location: user_login.php");
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

