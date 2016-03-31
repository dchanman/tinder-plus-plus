<?php

include 'credentials.php';
include ('sql-cmds.php');

ini_set('session.save_path', $cshomedir.'/public_html/php_sessions');
session_start();

//$db_conn = OCILogon("ora_n4u8", "a38777124", "ug");
//$db_conn = OCILogon("ora_z2p8", "a37087129", "ug");
$db_conn = OCILogon("ora_".$csid, "a".$studentnum, "ug");

$user_check = $_SESSION['login_user'];

// query for user information
$name_query = executePlainSQL("select name,age,gender, preference
					 from Users 
					 where userName = '$user_check'");

$name_row = oci_fetch_array($name_query, OCI_BOTH);

// get user's name
$name_result = $name_row[0];
$name_trim = trim($name_result);
$_SESSION['userName'] = $name_trim;
$user_name = $name_trim;

// TODO: get user's location

// get user's age
$age_result = $name_row[1];
$age_trim = trim($age_result);
$_SESSION['userAge'] = $age_trim;
$user_age = $age_trim;

// get user's gender
$gender_result = $name_row[2];
$gender_trim = trim($gender_result);
$_SESSION['userGender'] = $gender_trim;
$user_gender = $gender_trim;

$preference_result = $name_row[3];
$preference_trim = trim($preference_result);
$_SESSION['preference'] = $preference_trim;
// get user's InterestInMen
/*$iim_result = $name_row[3];
$iim_trim = trim($iim_result);
$user_iim = $iim_trim;

// get user's InterestInWomen
$iiw_result = $name_row[4];
$iiw_trim = trim($iiw_result);
$user_iiw = $iim_trim;
*/
if($preference_trim == 2){
	$_SESSION['userInterest'] = "Men & Women";
}
else if($preference_trim == 1){
	$_SESSION['userInterest'] = "Men";
}
else if($preference_trim == 0){
	$_SESSION['userInterest'] = "Women";
}
else{
	$_SESSION['userInterest'] = "Mystery";
}

$user_interest = $_SESSION['userInterest'];

if(!isset($user_name)){
	oci_commit($db_conn);
	oci_close($db_conn);
	header('Location: user_login.php'); // Redirecting To Home Pge
}

?>
