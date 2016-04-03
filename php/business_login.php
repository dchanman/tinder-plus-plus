<?php
include 'credentials.php';
include 'verify.php';

?>
<html>
 	<head>
    	<link href="assets/css/custom.css" rel="stylesheet">
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
		<div class="maincontent">
			<div class="center-text container">
				<h1>Tinder++ Business Login</h1>
				</br>
				<p>	Before you can enjoy our new features, please log in to continue</p>
			</div>
			<div id="container">
					<form method="POST" action="business_login.php" class="form-inline">

							<div class="form-group">
								<input type="text" class="form-control text-inputbox" name="businessName" placeholder="Business Name"><br>
								<input type="password" class="form-control text-inputbox" name="businessPwd" placeholder="Password">
							</div>
							<input id="BusinessLogin" class="btn btn-success form-control" type="submit" value="Continue" name="BusinessLogin"></p>
							</div>
							<span><?php echo $error; ?></span>
					</form>

					<div id="signup3 center-text">
						<p>Tinder++ is free and always will be!</p>
						<input type="button" class="btn btn-primary" value="Sign up" onclick="businessSignup();"></p>
					</div>
			</div>
		</div>

    </body>
</html>
