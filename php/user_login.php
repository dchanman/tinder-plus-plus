<?php

include 'credentials.php';
include 'verify.php';

?>
<html>
 	<head>
  		<title>Tinder++</title>
  		
		<?php include 'head-includes.php' ?>
  		<script> 
		    function UserSignup(){
		    	window.location = "newuser.php"
		    }
    </script>
	</head>
 	<body>
		<?php include 'menu.php';?>
 		<p>Welcome to Tinder++ </br>
 		</br>
 			Before you can enjoy our new features, please log in to continue</p>

 		<div id="login">
 			<form method="POST" action="user_login.php">
 				<p>
 					<label for="username">Username:</label>
 					<input type="text" name="userName" placeholder="username" size="16"></br>
 					<label for="userPwd">Password:</label>
 					<input type="password" name="userPwd" placeholder="**********" size="16"><br>
					<input id="UserLogin" type="submit" value="Login" name="UserLogin"></p>
					<span><?php echo $error; ?></span>
			</form>
		</div>

		<div id="userSignup">
			<input type="button" value="Sign up for free" onclick="UserSignup();"></p>
		</div>
    </body>
</html>
