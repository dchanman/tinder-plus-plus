<html>
 	<head>
  		<title>Welcome to Tinder++</title>
		<?php include 'head-includes.php' ?>
	</head>
 	<body>
		<?php include 'menu.php';?>
		<p>Tinder++ Signup!</p><br>
		<p>UserID:<p><br>
		<form method="POST" action="newuser.php">
			Username: <input type="text" name="username_text" size="6"><br>
			Name: <input type="text" name="name_text" size="6"><br>
			Password: <input type="password" name="password_text" size="6"><br>
			Confirm Password: <input type="password" name="confirm_password_text" size="6"><br>

			Age: <input type="text" name="age_text" size='6'><br>
			Location: <input type="text" name="location_text" size="6"><br>
			Gender: <br>
			<input type="radio" name="gender" value="m"> Male<br>
			<input type="radio" name="gender" value="f"> Female<br>
			Preference: <br>
			Men: <input type="checkbox" name="interestedInMen" value=1>
			Women: <input type="checkbox" name="interestedInWomen" value=1>
			<input type="submit" value="Sign Up!" name="signup">
		</form>
	</body>
</html>

<?php
  include 'credentials.php';
  include 'sql-cmds.php';

  if ($db_conn) {

   if (array_key_exists('signup', $_POST)) {
		// Drop old table...
		$tuple = array (
			":username_text" => $_POST['username_text'],
			":name_text" => $_POST['name_text'],
			":password_text" => $_POST['password_text'],
			":confirm_password_text" => $_POST['confirm_password_text'],
			":password_hash" => '',
			":username_text" => $_POST['username_text'],
			":gender" => $_POST['gender'],
			":age_text" => $_POST['age_text'],
			":location_text" => $_POST['location_text'],
			":interestedInMen" => $_POST['interestedInMen'],
			":interestedInWomen" => $_POST['interestedInWomen'],
			":date_joined" => date("m.d.Y")
			//date("m.d.y")
		);
		if($tuple[':password_text'] != $tuple[':confirm_password_text']){
			echo "Passwords don't match";
			printResult($result);
			return;
		}

		if($tuple[':interestedInMen'] != NULL){
			if($tuple[':interestedInWomen'] != NULL){
				$tuple[':preference'] = 2;
			}else{
				$tuple[':preference'] = 1;
			}
		}else if($tuple[':interestedInWomen'] != NULL){
			$tuple[':preference'] = 0;
		}else{
			echo "Must pick interest";
			printResult($result);
			return;
		}

		$tuple[':password_hash'] = crypt($tuple[':password_text']);
		//password_hash($tuple[':password_text'], PASSWORD_DEFAULT);
		$alltuples = array (
			$tuple
		);
		/* UserIDSequence.nextval automatically gets the next available user ID for us from the database */
		/* Note that if the insert fails, we still increment the sequence... lol */
		executeBoundSQL("INSERT INTO users VALUES (UserIDSequence.nextval, :username_text, :name_text, :date_joined, :location_text, :age_text, :gender, :preference, :password_hash)", $alltuples);
		// Create new table...
		echo "<br> creating new user <br>";
		OCICommit($db_conn);
	}



    printTable('users');
    printTable('image');

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

