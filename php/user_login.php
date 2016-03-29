<?php

include 'verify.php';

// if(isset($_SESSION['login_user'])){
// 	header("location: user_profile.php");
// }
?>
<html>
 	<head>
  		<title>Tinder++</title>
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	</head>
 	<body>
 		<p>Welcome to Tinder++ </br>
 		</br>
 			Before you can enjoy our new features, please log in to continue</p>

 		<div id="login">
 			<p>Please log in to continue.</p>
 			<form method="POST" action="user_login.php">
 				<p>
 					<label for="username">Username:</label>
 					<input type="text" name="userName" placeholder="username" size="16"></br>
 					<label for="userPwd">Password:</label>
 					<input type="password" name="userPwd" placeholder="**********" size="16"><br>
					<input id="UserLogin" type="submit" value="Continue" name="UserLogin"></p>
					<span><?php echo $error; ?></span>
			</form>

			<!-- <p>If you are a business, please log in here.</p>

 			<form method="POST" action="index.php">
 				<p>
 					<label for="businessName">Business Name:</label>
 					<input type="text" name="businessName" placeholder="businessname" size="16"></br>
 					<label for="businessPwd">Password:</label>
 					<input type="password" name="businessPwd" placeholder="**********" size="16"><br>
					<input type="submit" value="Continue" name="BusinessLogin"></p>
					<span><?php $error; ?></span>
			</form> -->
		</div>

		<div id="signup3">
			<h1>Sign up for Free</h1>
			<button id="userSignup">Sign up now!</button>
		</div>
    </body>
     <script>
 //    function setCookie(cname, cvalue, exdays) {
	//     var d = new Date();
	//     d.setTime(d.getTime() + (exdays*24*60*60*1000));
	//     var expires = "expires="+d.toUTCString();
	//     document.cookie = cname + "=" + cvalue + "; " + expires;
	// }

	// $("#test").click(function(){
	// 	var userName = $("#userName").val();
	// 	var password = $("#password").val();
	// 	var data = {username: userName, password: password};
	// 	var url = "login.php";
	// 	callAjax(url, data);
	// });

	// var callAjax = function(url, data){
	// 	$.ajax({
	// 		type: "POST",
	// 		url: url,
	// 		data: data,
	// 		contentType: 'application/json',
	// 		success: function(data, textStatus, jqXHR) {
	// 			console.log(data);
	// 		},
	// 		error: function(jqXHR, textStatus, error){

	// 		},
	// 		complete: function(jqXHR, textStatus){

	// 		}
	// 	});
	// }

     </script>
</html>
