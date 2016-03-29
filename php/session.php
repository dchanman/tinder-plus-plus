<?php

include ('sql-cmds.php');
session_save_path("home/n/n4u8/public_html/php_sessions");
session_start();

//$db_conn = OCILogon("ora_n4u8", "a38777124", "ug");
$db_conn = OCILogon("ora_z2p8", "a37087129", "ug");

$user_check = $_SESSION['loginUser'];

$s = executePlainSQL("select userName
					 from Users 
					 where userName = '$user_check'");

$row = oci_fetch_array($s, OCI_BOTH);
$result = $row[2];

$_SESSION['userName'] = $result;

// free the resrouces which was received from oci_parse
if(!isset($row)){
	oci_free_statement($s);
	oci_close($db_conn);
}



// $login_session =$result['username'];

// if(!isset($login_session)){
// 	oci_commit($db_conn);
// 	oci_close($db_conn);
// 	header('Location: index.php'); // Redirecting To Home Page
// }

?>
