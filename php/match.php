<html>
 	<head>
  		<title>Tinder++</title>
	</head>
 	<body>
 		<form method="POST" action="match.php">
	 	<p><input type="text" name="userID" size="6">
		<input type="submit" value="GO" name="update"></p>
		</form>

 		<?php
 		include 'sql-cmds.php';
 		//printTable('users');
    	//printTable('image');

    	if ($db_conn) {

		    if (array_key_exists('update', $_POST)) {
		    	/* Get the userID from the post */
		    	$userid = $_POST['userID'];

		    	/* Get the user's images */
		      	echo "<p> retrieving " . $userid . "</p>";
		      	$result = query_images($userid);

		      	$name = $result[name];
		      	echo "<h1>$name</h1>";
		      	$age = $result[age];
		      	echo "<p>Age: <b>$age</b></p>";

		      	/* Display the iamges */
		      	foreach ($result['images'] as $img) {
		      		echo "<p><img src=\"" . $img . "\" width=150></img></p>";
		      	}
		    }

			} else { /* if ($db_conn) */
		    	echo "cannot connect";
			    $e = OCI_Error(); // For OCILogon errors pass no handle
			    echo htmlentities($e['message']);
			}
		 ?>

		<p>
		<form method="POST" action="match.php">
	 	<input type="submit" value="HOT" name="hot">
	 	<input type="submit" value="NOT" name="not">
		</form>
		</p>

    </body>
</html>
