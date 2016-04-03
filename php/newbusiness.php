<html>
 	<head>
  		<title>Welcome to Tinder++</title>
    	<link href="assets/css/custom.css" rel="stylesheet">
		<?php
			include 'head-includes.php';
			include 'credentials.php';
  			include 'sql-cmds.php';
		?>
	</head>
 	<body>
		<?php include 'menu.php';?>
		<div class='maincontent'>
		<h2>Tinder++: Signup your Business!</h2>
		<form method="POST" action="newbusiness.php" class="form-inline">
			<input type="text" name="username_text" class="form-control" size="20" placeholder="Business Name"><br>
			<input type="password" name="password_text" class="form-control" size="20" placeholder="Password"><br>
			<input type="password" name="confirm_password_text" class="form-control" size="20" placeholder="Confirm Password"><br>

			<?php
			/* Location dropdown box */
			echo 'Location:
			<select name="location_text" class="form-control">';
			$locations = query_getLocations();
			foreach($locations as $loc) {
				echo "<option value='$loc'>$loc</option>";
			}
			echo "<option selected=selected></option>";
			echo '</select><br>';
			?>

			<input type="submit" value="Signup your Business!" class="btn btn-success" name="signup">
		</form>
		</div>
	</body>
</html>

<?php
  if ($db_conn) {

   if (array_key_exists('signup', $_POST)) {
		
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



		//$password_hash = crypt($_POST['password_text']);

		$resultArr = insert_addNewBusiness($_POST['username_text'], $_POST['location_text'], $_POST['password_text']);

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
    		header("Location: business_login.php");
		}
	}

    /* Commit to save changes... */
    OCICommit($db_conn);

    /* LOG OFF WHEN YOU'RE DONE! */
    OCILogoff($db_conn);

  } else { /* if ($db_conn) */
    echo "cannot connect";
    $e = OCI_Error(); // For OCILogon errors pass no handle
    echo htmlentities($e['message']);
  }
?>

		
