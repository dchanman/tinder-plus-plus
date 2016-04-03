<?php
include 'credentials.php';
include 'verify.php';
?>

<html>
 	<head>
  		<title>Tinder++</title>
		<?php include 'head-includes.php'?>
		<script src="assets/js/custom.js"></script>
    	<link href="assets/css/custom.css" rel="stylesheet">
	</head>
 	<body>
		<?php include 'menu.php';?>
		<div class="maincontent">
			<div class="container">
				<div class="jumbotron">
					<h1>Tinder++ User Login</h1>
					<p>Before you can enjoy our new features, please log in to continue</p>
				</div>
			</div>
			<div id="login">
				<div class="container">
					<form method="POST" action="user_login.php" class="form-inline">
						<div class="form-group">
							<input type="text" class="form-control text-inputbox" name="userName" placeholder="Username"><br>
							<input type="password" class="form-control text-inputbox" name="userPwd" placeholder="Password">
						</div>
						<div class="form-group">
							<input id="UserLogin" class="form-control btn btn-success" type="submit" value="Continue" name="UserLogin"></p>
						</div>
					</form>
				</div>
				<p class="error" ><?php echo $error; ?></p>
				<div id="userSignup">
					<p>Tinder++ is free and always will be!</p>
					<input type="button" class="btn btn-primary" value="Sign up" onclick="UserSignup();"></p>
				</div>
			</div>
		</div>
    </body>
</html>
