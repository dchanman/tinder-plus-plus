<?php
session_start();
$error=''; // Variable To Store Error Message
if (isset($_POST['UserLogin'])) {
	if (empty($_POST['userName']) || empty($_POST['userPwd'])) {
		$error = "Username or Password is invalid";
	}

	else{
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
					echo "Valid username and password";
					$_SESSION['login_user']=$inputname; // Initializing Session
					header("location: user_profile.php"); // Redirecting To Other Page
				}
				else{
					echo '<script type="text/javascript">alert("Username or Password is incorrect. Please try Again.");</script>';
				}

				
			}

			else if(array_key_exists('BusinessLogin', $_POST)){

				$inputname = $_POST['businessName'];
				echo ($inputname."</br>");
				$inputpwd = $_POST['businessPwd'];
				echo ($inputpwd."</br>");

				$s = executePlainSQL("select count (*)
								from Business 
								where BusinessName = '$inputname' AND 
								PasswordHash = '$inputpwd'");

				$result = oci_fetch_array($s);

				if($result[0]==1){
					echo "Valid Business name and password";
					$_SESSION['login_business']=$inputname; // Initializing Session
					header("location: business_profile.php"); // Redirecting To Other Page
				}
				else{
					echo '<script type="text/javascript">alert("Business Name or Password is incorrect. Please try Again.");</script>';
				}
			}
			OCILogoff($db_conn);
		}
		else{
			echo "cannot connect";
			$e = OCI_Error(); // For OCILogon errors pass no handle
			echo htmlentities($e['message']);
		}
	}
}
?>