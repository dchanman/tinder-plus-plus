<?php
  include 'session.php';
  ini_set('session.save_path', $cshomedir.'/public_html/php_sessions');
  session_start();
?>

<html>
 	<head>
  		<title>Welcome to Tinder++</title>
    	<link href="assets/css/custom.css" rel="stylesheet">
		<script src="assets/js/custom.js"></script>
		<?php include 'head-includes.php' ?>
		<script>
			<!-- i don't know wht this function is for, but after you finish implementing it, throw it into custom.js plz -->
			function viewSuggestedDate(){

			}
		</script>
	</head>
 	<body>

 	<?php include 'menu.php' ?>
	<div class='maincontent'>
 	<ul class = "nav nav-tabs">

	 	<li class="dropdown">
	    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Sort Matches
	    <span class="caret"></span></a>
	    <ul class="dropdown-menu">
		 	<li role="presentation">
		 		<form method='POST' action='test-messaging.php'>
		 			<button name='orderByMessageCount' class='btn btn-link' type='submit'>Order By Message Count</button>
		 		</form>
		 	</li>
		 	<li role="presentation">
		 		<form method='POST' action='test-messaging.php'>
		 			<button name='orderByCommonInterests' class='btn btn-link' type='submit'>Order By Common Interests</button>
		 		</form>
		 	</li>
		  	<li role="presentation">
		 		<form method='POST' action='test-messaging.php'>
		 			<button name='defaultOrder' class='btn btn-link' type='submit'>Default Ordering</button>
		 		</form>
		 	</li>
		 </ul>

		 <li class="dropdown">
	    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Sort Matches
	    <span class="caret"></span></a>
	    <ul class="dropdown-menu">
		 	<li role="presentation">
		 		<form method='POST' action='test-messaging.php'>
		 			<button name='filterOnlyPerfectMatches' class='btn btn-link' type='submit'>Filter Incompatible Interests</button>
		 		</form>
		 	</li>
		 </ul>

 	</ul>

 	<?php
			if ($db_conn) {

			/* default query function pointer set here */
			$queryFunctionPtr = $_SESSION['matchOrderBy'];
			if ($_SESSION['matchOrderBy'] === FALSE)
				$queryFunctionPtr = 'query_getSuccessfulMatches';


			/* Handle POSTs */
			if (array_key_exists('insert_sendMessage', $_POST)) {
				insert_sendMessage($user_userid, $_POST['insert_sendMessage'], $_POST['messageStr']);
				/* Commit to save changes... */
				OCICommit($db_conn);

			} else if (array_key_exists('block', $_POST)) {
				echo "<p>blocking ".$_POST['block']."</p>";
				insert_match($user_userid, $_POST['block'], 'f');
				/* Commit to save changes... */
				OCICommit($db_conn);

			} else if (array_key_exists('orderByMessageCount', $_POST)) {
				$queryFunctionPtr = 'query_getSuccessfulMatchesOrderByMessageCount';

			} else if (array_key_exists('orderByCommonInterests', $_POST)) {
				$queryFunctionPtr = 'query_getSuccessfulMatchesOrderByCommonInterests';
				
			} else if (array_key_exists('defaultOrder', $_POST)) {
				$queryFunctionPtr = 'query_getSuccessfulMatches';

			} else if (array_key_exists('filterOnlyPerfectMatches', $_POST)) {
				$queryFunctionPtr = 'query_getPerfectMatches';
			}
			
			/* Remember the current query function pointer */
			$_SESSION['matchOrderBy'] = $queryFunctionPtr;


			if ($_SESSION['login_user']) {
				$username = $_SESSION['login_user'];
				$id = query_getIdFromUsername($username);
				$matchIds = $queryFunctionPtr($id);
		
				/* Display the users */
	      		foreach ($matchIds as $matchId) {
	      			/* Display the match's name */
					$receiverUser = query_getNameFromId($matchId);
					echo "<h2>$receiverUser</h2>";
					/* Display the user's location */
					$locationResult = query_userInformationWithUserID($matchId);
					$location = $locationResult['location'];
					echo "<h4>$location</h4>";

	      			/* Display the match's first photo */
	      			$images = query_images($matchId);
	      			if ($images[0])
	      				echo "<p><img src=\"" . $images[0] . "\" width=75></img></p>";

	      			/* Display the common interests between two users */
					$commonInterestResult = query_getCommonInterests($id, $matchId);
					$commonInterests = $commonInterestResult['commonInterests'];

					if (!isset($commonInterests)) {
						echo "<h4>Find something in common through messaging!</h4></br>";
					} else {
						echo "<h4>Common Interests: </h4><ul>";
						foreach ($commonInterests as $commonInterest){
							echo "<li>$commonInterest</li>";	
						}
						echo "</ul>";
					}
								
					/* Display convo */
					$convo = query_getConversation($user_userid, $matchId);
					foreach ($convo as $msg) {
						echo "<b>".($msg[sender] == $user_userid ? $user_name : $receiverUser)."</b>: ";
						echo $msg[message];
						echo "<br>";
					}

					
					
					/* Create SEND button with the value set to the receiverID */
		      		echo "<form method='POST' action='test-messaging.php'>
					<input type='text' name='messageStr'>
					<button name='insert_sendMessage' value='$matchId' class='btn btn-info' type='submit'>Send</button>
					</form>";
					/* View Suggested Date Based on the common interest */
					echo "<input id='suggestedDate' type='submit' value='View Suggested Date' class='btn btn-warning' name='suggestedDate' onclick='viewSuggestedDate()'>";
					/* Create BLOCK button with the value set to the receiverID */
		      		echo "<form method='POST' action='test-messaging.php'>
					<button name='block' value='$matchId' type='submit' class='btn btn-danger' onclick='blockUser()'>Block</button>
					</form>";
		      	}
			}
			/* LOG OFF WHEN YOU'RE DONE! */
			OCILogoff($db_conn);
			} else { /* if ($db_conn) */
			echo "cannot connect";
			$e = OCI_Error(); // For OCILogon errors pass no handle
			echo htmlentities($e['message']);
			}
		?>
		</div>
		<?php 
		include 'footer_menu.php';
		?>

	</body>
</html>
