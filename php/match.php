<html>
 	<head>
		<?php include 'head-includes.php' ?>
  		<title>Tinder++</title>
    	<link href="assets/css/custom.css" rel="stylesheet">
	</head>
 	<body>
		<?php include 'menu.php';?>

		<div class="maincontent">
 	 	<?php
 	 	include 'session.php';


    	if ($db_conn) {

			/* Deal with POST requests */
		    if (array_key_exists('hot', $_POST)) {
		    	insert_match($user_userid, $_POST['matchwith'], 't');
		    } else if (array_key_exists('not', $_POST)) {
		    	insert_match($user_userid, $_POST['matchwith'], 'f');
		    }

			/* Get all users this user has yet to try matching with */
			$result = query_getUnmatchedUsers($user_userid);
			/* Grab the first one */
			$unmatchedUser = $result['unmatchedUsers'][0];

			if ($unmatchedUser) {
				/* If unmatchedUser exists, display their profile */

				/* Get their profile information */
				$result = query_userInformationWithUserID($unmatchedUser);
				$name = $result['name'];
		      	$age = $result['age'];

				/* Get this user's images */
		      	$result = query_images($unmatchedUser);		      	

				echo "<h1>$name </h1>";
		      	echo "<p>Age: $age <b></b></p>";

		      	/* Display the images */
		      	foreach ($result as $img) {
		      		echo "<p><img src=\"" . $img . "\" width=150></img></p>";
		      	}

		      	/* Get common interests */
		      	$result = query_getCommonInterests($user_userid, $unmatchedUser);

		      	/* Display the interests */
		      	echo "<b>Common Interests</b><br>";
		      	foreach ($result['commonInterests'] as $commonint) {
		      		echo "$commonint<br>";
		      	}

		      	/* Display HOT/NOT buttons */
				echo '
				<p>
				<form method="POST" action="match.php">
				<input type="hidden" value='.$unmatchedUser.' name="matchwith">
			 	<input type="submit" value="HOT" name="hot">
			 	<input type="submit" value="NOT" name="not">
				</form></p>
				';

			} else {
				echo "<p>Hello $user_name, there's nobody new to match with!</p>";
				echo "<p>Chat with your matches <a href=\"test-messaging.php\">here</a>!</p>";
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
		<?php 
			include 'footer_menu.php';
		?>

		</div>
	</body>
</html>
