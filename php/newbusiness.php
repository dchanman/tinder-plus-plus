<html>
 	<head>
  		<title>Welcome to Tinder++</title>
		<?php include 'head-includes.php' ?>
	</head>
 	<body>
		<?php include 'menu.php';?>
		<p>Tinder++ Signup your Business!</p><br>
		<p>UserID:<p><br>
		<form method="POST" action="newbusiness.php">
			Username: <input type="text" name="username_text" size="6"><br>
			Password: <input type="password" name="password_text" size="6"><br>
			Confirm Password: <input type="password" name="confirm_password_text" size="6"><br>

			Location: <input type="text" name="location_text" size="6"><br>
			<input type="submit" value="Signup your Business!" name="signup">
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
			":password_text" => $_POST['password_text'],
			":confirm_password_text" => $_POST['confirm_password_text'],
			":password_hash" => '',
			":location_text" => $_POST['location_text'],
		);
		if($tuple[':password_text'] != $tuple[':confirm_password_text']){
			echo "Passwords don't match";
			printResult($result);
			return;
		}

		$tuple[':password_hash'] = crypt($tuple[':password_text']);
		$alltuples = array (
			$tuple
		);
		/* UserIDSequence.nextval automatically gets the next available user ID for us from the database */
		/* Note that if the insert fails, we still increment the sequence... lol */
		executeBoundSQL("INSERT INTO business VALUES (BusinessIDSequence.nextval, :username_text, :location_text, :password_hash)", $alltuples);
		// Create new table...
		echo "<br> creating new business <br>";
		OCICommit($db_conn);
	}



	printTable('business');

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

		
