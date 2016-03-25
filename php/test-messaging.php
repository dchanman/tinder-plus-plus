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
				
				$username = 'Billy';
				$id = getIdFromUsername($username);
				$matchIds = getMatchesFromId($id);
			
				echo "<form method='POST' action='test-messaging.php'>
				Username: $username<br>
				echo <input type='submit' value='Sign Up!' name='signup'>";
				

   				if (array_key_exists('sendmessage', $_POST)) {
					
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
		
	</body>
</html>


