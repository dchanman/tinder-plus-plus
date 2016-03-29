<?php
  include 'sql-cmds.php';
  //ini_set('session.save_path', '/home/n/n4u8/public_html/php_sessions');
  ini_set('session.save_path', '/home/n/z2p8/public_html/php_sessions');
  session_start();
  
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
				
				if ($_SESSION['login_user']) {
					$username = $_SESSION['login_user'];
					$id = getIdFromUsername($username);
					$matchIds = getMatchesFromId($id);
			
					echo "<form method='POST' action='test-messaging.php'>
					Username: $username<br>
					<input type='submit' value='Sign Up!' name='signup'><br>";
			
					/* Display the users */
		      		foreach ($matchIds as $matchId) {
						$receiverId = getUsernameFromId($matchId);
			      		echo "<form method='POST' action='test-messaging.php'>
						Message String: <input type='text' name='messageStr'>
						Receiver: <input type='text' name='receiverId' value='$matchId' readonly='true'>
						<input type='submit' value='Send Message to $receiverId' name='sendMessage'>
						</form>";
			      	}
	
					$_POST['TESTTEST'] = '1';	
	
	   				if (array_key_exists('sendMessage', $_POST)) {
						$TEST1 = 1;
						$TEST2 = 2;
						$TEST3 = 'fsdfdE';
						sendMessage($id, $_POST['receiverId'], $_POST['messageStr']);
					}
				
					printTable('message');
	
	
	    			/* Commit to save changes... */
	    			OCICommit($db_conn);
				}
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


