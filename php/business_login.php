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
 		<h1 style="width:800px; margin:0 auto;">Tinder++ Business Login</h1>
 		</br>
 		<p style="width:800px; margin:0 auto;">
 			Before you can enjoy our new features, please log in to continue</p>

		<div id="login" style="width:800px; margin:0 auto;">
 			<form method="POST" action="business_login.php" class="form-inline">

 					<div class="col-xs-3 form-group">
 					<input type="text" class="form-control col-xs-3" name="businessName" placeholder="Business Name">
  					<input type="password" class="form-control" name="businessPwd" placeholder="Password">
 					<input id="BusinessLogin" class="btn btn-default" type="submit" value="Continue" name="BusinessLogin"></p>
 					</div>
					<span><?php echo $error; ?></span>
			</form>

			<div id="signup3">
				<p>Tinder++ is free and always will be!</p>
				<input type="button" class="btn btn-default" value="Sign up" onclick="businessSignup();"></p>
			</div>
		</div>

    </body>
</html>
