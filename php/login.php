<?php
include 'sql-cmds.php';
session_save_path("home/n/n4u8/public_html/php_sessions");
session_start();
$id = session_id();
echo ($id."</br>");
$error=''; // Variable To Store Error Message
if (isset($_POST['UserLogin'])) {
	if (empty($_POST['userName']) || empty($_POST['userPwd'])) {
		$error = "Username or Password is invalid";
	}

	// else if (empty($_POST['businessName']) || empty($_POST['businessPwd'])) {
	// 	$error = "Business Name or Password is invalid";
	// }

	else{

		// connect to DB
		$db_conn = OCILogon("ora_n4u8", "a38777124", "ug");

		echo "connecting to db<br>";
		// now connected
		if ($db_conn) {

			// grab the information needed for login
			$inputname = $_POST['userName'];
			$inputpwd = $_POST['userPwd'];
		
			// query for information obtained
			$s = executePlainSQL("select count (*)
								from Users 
								where UserName = '$inputname' AND 
								PasswordHash = '$inputpwd'");

			$result = oci_fetch_array($s);
			echo("result is" . $result[0]. "<br>");
			$_SESSION['loginUser'] = $inputname;// Initializing Session
			echo("session saved as: ".$_SESSION['loginUser']. "</br>");

			// if there was a result from a query, allow log in
			if($result[0]!=0){
		 		$_SESSION['loginUser'] = $inputname;// Initializing Session
		 		echo($_SESSION['loginUser']);
				header("location: user_profile.php"); // Redirecting To Other Page
				session_write_close();
			}
			else{
				$error = "Username or Password is invalid";
			}
		}
		// can't connect, show error
		else{
			echo "cannot connect";
			$e = OCI_Error(); // For OCILogon errors pass no handle
			echo htmlentities($e['message']);
		}
		// save and close the connection
			oci_commit($db_conn);
			oci_close($db_conn);
	}
}
?>