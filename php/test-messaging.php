<?php
  include 'sql-cmds.php';
?>



<html>
 	<head>
  		<title>Welcome to Tinder++</title>
	</head>
 	<body>
		<p>Tinder++ Messages</p><br>
		<p>Messages<p><br>

		<?php
  			if ($db_conn) {
				
   				if (array_key_exists('sendmessage', $_POST)) {
					
				}

				$id = getIdFromUsername('Peter Chung');

				echo "<form method='POST' action='test-messaging.php'>
				Username: '$result_text'<br>
				Age: <input type='text' name='age_text' size='6'><br>
				Location: <input type='text' name='location_text' size='6'><br>";
			

				echo "<input type='submit' value='Sign Up!' name='signup'>";



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
		
	</body>
</html>


