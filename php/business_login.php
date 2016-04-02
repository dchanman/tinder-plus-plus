<?php
include 'credentials.php';
include 'verify.php';


?>
<html>
 	<head>
  		<title>Tinder++</title>
		<?php include 'head-includes.php' ?>
  	  	<script>
  			function businessSignup(){
  				window.location = "newbusiness.php";
  			}
  		</script>
	</head>
 	<body>
		<?php include 'menu.php';?>
 		<p>Welcome to Tinder++ </br>
 		</br>
 			Before you can enjoy our new features, please log in to continue</p>

 		<div id="login">
 			<!-- <p>Please log in to continue.</p> -->
 			<!-- <form method="POST" action="user_login.php">
 				<p>
 					<label for="username">Username:</label>
 					<input type="text" name="userName" placeholder="username" size="16"></br>
 					<label for="userPwd">Password:</label>
 					<input type="password" name="userPwd" placeholder="**********" size="16"><br>
					<input id="UserLogin" type="submit" value="Continue" name="UserLogin"></p>
					<span><?php $error; ?></span>
			</form> -->

			<p>Please log in to continue.</p>

 			<form method="POST" action="business_login.php">
 				<p>
 					<label for="businessName">Business Name:</label>
 					<input type="text" name="businessName" placeholder="businessname" size="16"></br>
 					<label for="businessPwd">Password:</label>
 					<input type="password" name="businessPwd" placeholder="**********" size="16"><br>
					<input id="BusinessLogin "type="submit" value="Continue" name="BusinessLogin"></p>
					<span><?php echo $error; ?></span>
			</form>
		</div>

		<div id="signup3">
			<h1>Sign up for Free</h1>
			<input type="button" value="Sign Up" onclick="businessSignup();"></p>
		</div>
    </body>
</html>
