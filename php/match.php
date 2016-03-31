<html>
 	<head>
  		<title>Tinder++</title>
	</head>
 	<body>
 	 	<?php
 		include 'sql-cmds.php';
		//ini_set('session.save_path', '/home/n/n4u8/public_html/php_sessions');
		ini_set('session.save_path', '/home/z/z2p8/public_html/php_sessions');
		session_start();

		/* Hacky: Keep the userid in the text field for now until we get our cookie */
 		echo '<form method="POST" action="match.php">';
	 	echo '<p>Account ID: <input type="text" name="myUserID" value="' . $myUserID .'"size="1"></p>';

	 	echo '<p>Match With: <input type="text" name="userID" value="' . $userID .'"size="1">';
		echo '<input type="submit" value="GO" name="update"></p></form>';

    	if ($db_conn) {

			/* Get the userID from the post */
			$myUserID = getIdFromUsername($_SESSION['login_user']);
			$userID = rand(1,5);
			$nextUserID = rand(1,5);
			//TODO hacky way of ensuring next userid and userid aren't same, need to properly query for new potential matches
			while($nextUserID == $myUserID){
				$nextUserID = rand(1,5); //TODO: Make next user the result of a query of a unmatched user
			}
			while($userID == $myUserID || $userID == $myUserID){
				$userID = rand(1,5);
			}
    		/* Deal with POST requests */
		    if (array_key_exists('hot', $_POST)) {
		    	insert_match($myUserID, $userID, 'T');
		    } else if (array_key_exists('not', $_POST)) {
		    	insert_match($myUserID, $userID, 'F');
		    }
    		

			/* Hacky: The first time you load this page, $userID will be NULL. Don't display anything then. */
		    if ($userID && $myUserID) {
		    	/* Get the user's images */
		      	$result = query_images($userID);

		      	$name = $result[name];
		      	echo "<h1>$name</h1>";
		      	$age = $result[age];
		      	echo "<p>Age: <b>$age</b></p>";

		      	/* Display the images */
		      	foreach ($result['images'] as $img) {
		      		echo "<p><img src=\"" . $img . "\" width=150></img></p>";
		      	}

		      	/* Get common interests */
		      	/* TEMP: query common interests of a user with themselves to see a full list */
		      	$result = query_getCommonInterests($myUserID, $userID);

		      	/* Display the interests */
		      	echo "<b>Common Interests</b><ul>";
		      	foreach ($result['commonInterests'] as $commonint) {
		      		echo "<li>$commonint</li>";
		      	}
		      	echo "</ul>";

		      	/* Make HOT/NOT point to the next userID */
			    echo '<p>';
				echo '<form method="POST" action="match.php">';
				echo '<input type="hidden" name="userID" value="' . $nextUserID . '">';
				echo '<input type="hidden" name="myUserID" value="' . $myUserID . '">';
			 	echo '<input type="submit" value="HOT" name="hot">';
			 	echo '<input type="submit" value="NOT" name="not">';
				echo '</form></p>';			
		    }

		    printTable('match');

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

    </body>
</html>
