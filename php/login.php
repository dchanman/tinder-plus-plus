<?php
session_start();
$error=''; // Variable To Store Error Message
if (isset($_POST['UserLogin'])) {
	if (empty($_POST['userName']) || empty($_POST['userPwd'])) {
		$error = "Username or Password is invalid";
	}

	// else if (empty($_POST['businessName']) || empty($_POST['businessPwd'])) {
	// 	$error = "Business Name or Password is invalid";
	// }

	else{
		include 'sql-cmds.php';

		$db_conn = OCILogon("ora_n4u8", "a38777124", "ug");

		if ($db_conn) {

			$inputname = $_POST['userName'];
			$inputpwd = $_POST['userPwd'];

			$s = executePlainSQL("select count (*)
								from Users 
								where UserName = '$inputname' AND 
								PasswordHash = '$inputpwd'");

			$result = oci_fetch_array($s);
			echo($result[0]);
			
			if($result[0]==1){
				$_SESSION['login_user']=$inputname; // Initializing Session
				header("location: user_profile.php"); // Redirecting To Other Page
			}
			else{
				$error = "Username or Password is invalid";
			}
			oci_commit($db_conn);
			oci_close($db_conn);
		}
		else{
			echo "cannot connect";
			$e = OCI_Error(); // For OCILogon errors pass no handle
			echo htmlentities($e['message']);
		}
	}
}
?>