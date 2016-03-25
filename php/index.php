<?php

include('login.php'); // Includes Login Script

if(isset($_SESSION['login_user'])){
	header("location: user_profile.php");
}

// if(isset($_SESSION['login_business'])){
// 	header("location: business_profile.php");
// }

?>
<html>
 	<head>
  		<title>Tinder++</title>
	</head>
 	<body>
 		<p>Welcome to Tinder++ </br>
 		</br>
 			Before you can enjoy our new features, please log in to continue!</p>

 		<div id="login">
 			<p>If you are a user, please log in here.</p>
 			<form method="POST" action="index.php">
 				<p>
 					<label for="username">Username:</label>
 					<input type="text" name="userName" placeholder="username" size="16"></br>
 					<label for="userPwd">Password:</label>
 					<input type="password" name="userPwd" placeholder="**********" size="16"><br>
					<input type="submit" value="Continue" name="UserLogin"></p>
			</form>

			<p>If you are a business, please log in here.</p>

 			<form method="POST" action="index.php">
 				<p>
 					<label for="businessName">Business Name:</label>
 					<input type="text" name="businessName" placeholder="businessname" size="16"></br>
 					<label for="businessPwd">Password:</label>
 					<input type="password" name="businessPwd" placeholder="**********" size="16"><br>
					<input type="submit" value="Continue" name="BusinessLogin"></p>
			</form>
		</div>

		<!-- <div id="signup3">
			<h1>Sign up for Free</h1>
			<button id="userSignup">User Sign Up</button>
			<button id="businessSignup">Business Sign up</button>
		</div> -->
    </body>
</html>
