<html>
 	<head>
  		<title>Welcome to Tinder++</title>
		<?php include 'head-includes.php' ?>
	</head>
 	<body>
		<?php include 'menu.php';?>
		<h1>Tinder++ Signup</h1><br>
		<form method="POST" action="newuser.php">
			<?php
			echo 'Username: <input type="text" name="username_text" size="6"><br>';
			echo 'Name: <input type="text" name="name_text" size="6"><br>';
			echo 'Password: <input type="password" name="password_text" size="6"><br>';
			echo 'Confirm Password: <input type="password" name="confirm_password_text" size="6"><br>';
			echo 'Age: <input type="text" name="age_text" size="6"><br>';
			echo 'Location:
			<select name="location_text">
				<option value="UBC">UBC</option>
				<option value="Vancouver">Vancouver</option>
				<option value="North Vancouver">North Vancouver</option>
				<option value="Downtown">Downtown Vancouver</option>
				<option value="Langley">Langley</option>
				<option value="Richmond">Richmond</option>
			</select><br>';
			echo 'Gender: <br>
			<input type="radio" name="gender" value="m"> Male<br>
			<input type="radio" name="gender" value="f"> Female<br>';
			echo 'Preference: <br>';
			echo 'Men: <input type="checkbox" name="interestedInMen" value="m">';
			echo 'Women: <input type="checkbox" name="interestedInWomen" value="f">';
			?>
			<br>
			<input type="submit" value="Sign Up!" name="signup">
		</form>
	</body>
</html>

<?php
  include 'credentials.php';
  include 'sql-cmds.php';

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
		}
    	OCICommit($db_conn);
	}

    printTable('users');

    /* LOG OFF WHEN YOU'RE DONE! */
    OCILogoff($db_conn);

  } else { /* if ($db_conn) */
    echo "cannot connect";
    $e = OCI_Error(); // For OCILogon errors pass no handle
    echo htmlentities($e['message']);
  }
?>

