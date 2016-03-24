<html>
 	<head>
  		<title>Tinder++</title>
	</head>
 	<body>
 		<?php

		 echo '<p>attractiveGRIL-1:23</p><br>';
		 echo 'UserID:TODO, INSERT USERNAME<br>';
		 echo '<img src="https://scontent-sea1-1.xx.fbcdn.net/hphotos-xal1/v/t1.0-9/11029476_10152322305804567_2592960065506022466_n.jpg?oh=6376df01f280c8b51fea68b26cbd8973&oe=575B6CAB"></img>';
		 echo '<img src="https://scontent-sea1-1.xx.fbcdn.net/hphotos-xpa1/t31.0-8/s960x960/1015380_10151615947279567_613389681_o.jpg"></img>';
		 echo '<img src="https://scontent-sea1-1.xx.fbcdn.net/hphotos-xfa1/v/t1.0-9/59051_10150966619654567_1499864983_n.jpg?oh=a1ff042d6cfcd31a64982a9b9c174031&oe=575B10C6"></img>';
		 echo 'Hot      Not';

		 echo 'TODO display matches';

		 // Connect Oracle...
	if ($db_conn) {

		if (array_key_exists('reset', $_POST)) {
			// Drop old table and create new one
			echo "<br> dropping table, creating new tables... <br>";
			runSQLScript('sql/schema.sql');

		} else if (array_key_exists('insertsubmit', $_POST)) {
				//Getting the values from user and insert data into the table
				$tuple = array (
					":bind1" => $_POST['insNo'],
					":bind2" => $_POST['insName']
				);
				$alltuples = array (
					$tuple
				);
				executeBoundSQL("insert into tab1 values (:bind1, :bind2)", $alltuples);
				OCICommit($db_conn);

		} else if (array_key_exists('updatesubmit', $_POST)) {
			// Update tuple using data from user
			$tuple = array (
				":bind1" => $_POST['oldName'],
				":bind2" => $_POST['newName']
			);
			$alltuples = array (
				$tuple
			);
			executeBoundSQL("update tab1 set name=:bind2 where name=:bind1", $alltuples);
			OCICommit($db_conn);

		} else if (array_key_exists('dostuff', $_POST)) {
			// Insert data into table...
			echo "inserting sample data into db...";
			runSQLScript('sql/sample.sql');
			OCICommit($db_conn);
		} else if (array_key_exists('login', $_POST)) {
			echo "logging in...";
			
			$user = array(
				'userid' => $id,
				'username' => $username,
				'login' => $login,
			);
			setcookie("loginCredentials", $user, time() * 7200);
		} else if (array_key_exists('signup', $_POST)) {
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

			if($tuple[':interestedInMen'] == NULL && $tuple[':interestedInWomen'] == NULL){
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
			executeBoundSQL("INSERT INTO users VALUES (UserIDSequence.nextval, :username_text, :name_text, :date_joined, :location_text, :age_text, :gender, :interestedInMen, :interestedInWomen, :password_hash)", $alltuples);

			// Create new table...
			echo "<br> creating new user <br>";
			OCICommit($db_conn);
		}else if(array_key_exists('updateLoc', $_POST)){
			$tuple = array(
				// assuming the profile page is already implemented and input name for new location is newLoc
				":bind1" => $_POST['userID'],
				":bind2" => $_POST['newLoc']
				);
			$alltuples = array(
				$tuple
				);
			executeBoundSQL("update Users set location=:bind2 where userID=:bind1", $alltuples);
			OCICommit($db_conn);
		}

		if ($_POST && $success) {
			//POST-REDIRECT-GET -- See http://en.wikipedia.org/wiki/Post/Redirect/Get
			$page = $_SERVER['PHP_SELF'];
			$sec = "1";
			header("Refresh: $sec; url=$page");
		} else {
			// Select data...
			$result = executePlainSQL("select * from Users");
		}

		//Commit to save changes...
		OCILogoff($db_conn);
	} else {
		echo "cannot connect";
		$e = OCI_Error(); // For OCILogon errors pass no handle
		echo htmlentities($e['message']);
	}
	printResult($result);

		 ?>
    </body>
</html>
