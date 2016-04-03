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
 			<form method="POST" action="user_login.php" class="form-inline">

 					<div class="col-xs-3 form-group">
 					<input type="text" class="form-control col-xs-3" name="userName" placeholder="Username">
  					<input type="password" class="form-control" name="userPwd" placeholder="Password">
 					<input id="UserLogin" class="btn btn-default" type="submit" value="Login" name="UserLogin"></p>
 					</div>
					<span><?php echo $error; ?></span>
			</form>

			<div id="userSignup">
				<p>Tinder++ is free and always will be!</p>
				<input type="button" class="btn btn-default" value="Sign up" onclick="UserSignup();"></p>
			</div>
		</div>

		
    </body>
</html>
