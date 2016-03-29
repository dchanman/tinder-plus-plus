<?php
include('session.php');
session_save_path("home/n/n4u8/public_html/php_sessions");
session_start();

if(isset($_SESSION['loginUser'])){
	echo "session copied.</br>";
}
if(!isset($_SESSION['loginUser'])){
	echo "session not copied.</br>";
}

print_r($_SESSION['loginUser']);
print_r($_SESSION);
echo ($username. " is your username. </br>");
$sesh_id = session_id();

echo "Your session is running: " . $sesh_id. " in this.";
if(isset($_SESSION['login_user'])){
	echo "Your session is running " . $_SESSION['loginUser'];
}

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Your Home Page</title>
		<!-- <link href="style.css" rel="stylesheet" type="text/css"> -->
	</head>
	<body>
		<h1>Welcome!</h1>
		<div id="profile">
			<b id="welcome">Welcome : <?php echo($_SESSION['userName']);?> </b>
			<b id="logout"><a href="logout.php">Log Out</a></b>
		</div>
	</body>
</html>