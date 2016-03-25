<?php
// include ('login.php');

session_start();
// // if(isset($_SESSION['login_user'])){
// // header("location: profile.php");
// // }

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

			<!-- <p>If you are a business, please log in here.</p>

 			<form method="POST" action="index.php">
 				<p>
 					<label for="businessName">Business Name:</label>
 					<input type="text" name="businessName" size="16"></br>
 					<label for="businessPwd">Password:</label>
 					<input type="password" name="businessPwd" size="16"><br>
					<input type="submit" value="Continue" name="BusinessLogin"></p>
			</form> -->
		</div>

		<!-- <div id="signup3">
			<h1>Sign up for Free</h1>
			<button id="userSignup">User Sign Up</button>
			<button id="businessSignup">Business Sign up</button>
		</div> -->
    </body>
</html>

<?php
	include 'sql-cmds.php';

	$db_conn = OCILogon("ora_n4u8", "a38777124", "ug");

	if ($db_conn) {

		if(array_key_exists('UserLogin', $_POST)){

			$inputname = $_POST['userName'];
			echo ($inputname."</br>");
			$inputpwd = $_POST['userPwd'];
			echo ($inputpwd."</br>");

			$s = executePlainSQL("select count (*)
							from Users 
							where UserName = '$inputname' AND 
							PasswordHash = '$inputpwd'");

			$result = oci_fetch_array($s);

			if($result[0]==1){
				echo "Valid username / password";
				$_SESSION['login_user']=$username; // Initializing Session
				header("location: profile.php"); // Redirecting To Other Page
			}
			else{
				echo "Username or Password is incorrect. Please try Again.";
			}

			
		}
		OCILogoff($db_conn);
	}
	else{
		echo "cannot connect";
		$e = OCI_Error(); // For OCILogon errors pass no handle
		echo htmlentities($e['message']);
	}
?>