<html>
 	<head>
  		<title>Tinder++</title>
	</head>
 	<body>
 	 	<?php
 	 	include 'session.php';


    	if ($db_conn) {

			//getUnmatchedIds(1);
			echo "<p>Signed in as <b>$user_name</b></p>";

			/* Get all users this user has yet to try matching with */
			$result = query_getUnmatchedUsers($user_userid);
			/* Grab the first one */
			$unmatchedUser = $result['unmatchedUsers'][0];

			if ($unmatchedUser) {
				/* Get this user's images */
		      	$result = query_images($unmatchedUser);
		      	$name = $result['name'];
		      	$age = $result['age'];

				echo "<h1>$name </h1>";
		      	echo "<p>Age: $age <b></b></p>";

		      	/* Display the images */
		      	foreach ($result['images'] as $img) {
		      		echo "<p><img src=\"" . $img . "\" width=150></img></p>";
		      	}

		      	/* Get common interests */
		      	/* TEMP: query common interests of a user with themselves to see a full list */
		      	$result = query_getCommonInterests($user_userid, $unmatchedUser);

		      	/* Display the interests */
		      	echo "<b>Common Interests</b><ul>";
		      	foreach ($result['commonInterests'] as $commonint) {
		      		echo "<li>$commonint</li>";
		      	}
		      	echo "</ul>";

		      	/* Make HOT/NOT point to the next userID */
				echo '
				<p>
				<form method="POST" action="match.php">
			 	<input type="submit" value="HOT" name="hot">
			 	<input type="submit" value="NOT" name="not">
				</form></p>
				';

	    		/* Deal with POST requests */
			    if (array_key_exists('hot', $_POST)) {
			    	insert_match($user_userid, $unmatchedUser, 'T');
			    } else if (array_key_exists('not', $_POST)) {
			    	insert_match($user_userid, $unmatchedUser, 'F');
			    }
			} else {
				echo "<p>Hello $user_name, there's nobody new to match with! Come back later!</p>";
			}

		    $nextUserID = rand(1,$matchIdsSize);    		

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
