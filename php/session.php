<?php

include 'credentials.php';
include ('sql-cmds.php');

ini_set('session.save_path', $cshomedir.'/public_html/php_sessions');
session_start();

$db_conn = OCILogon("ora_".$csid, "a".$studentnum, "ug");

$user_check = $_SESSION['login_user'];

// query for user information
$query_result = executePlainSQL("select *
					 from Users 
					 where userName = '$user_check'");

$query_row = oci_fetch_array($query_result, OCI_BOTH);

// get user's id
$userid_result = $query_row['USERID'];
$userid_trim=  trim($userid_result);
$_SESSION['userId'] = $userid_trim;
$user_userid = $userid_trim;

// get user's name
$name_result = $query_row['NAME'];
$name_trim = trim($name_result);
$_SESSION['userName'] = $name_trim;
$user_name = $name_trim;

// get user's location
$location_result = $query_row['LOCATION'];
$location_trim = trim($location_result);
$_SESSION['userlocation'] = $location_trim;
$user_location = $location_trim;

// get user's age
$age_result = $query_row['AGE'];
$age_trim = trim($age_result);
$_SESSION['userAge'] = $age_trim;
$user_age = $age_trim;

// get user's gender
$gender_result = $query_row['GENDER'];
$gender_trim = trim($gender_result);
$_SESSION['userGender'] = $gender_trim;
$user_gender = $gender_trim;

$preference_result = $query_row['PREFERENCE'];
$preference_trim = trim($preference_result);
$_SESSION['preference'] = $preference_trim;
// get user's InterestInMen
/*$iim_result = $query_row[3];
$iim_trim = trim($iim_result);
$user_iim = $iim_trim;

// get user's InterestInWomen
$iiw_result = $query_row[4];
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
