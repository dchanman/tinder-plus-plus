<?php

include 'credentials.php';
include 'sql-cmds.php';

ini_set('session.save_path', $cshomedir.'/public_html/php_sessions');
session_start();

$db_conn = OCILogon("ora_".$csid, "a".$studentnum, "ug");

$user_check = $_SESSION['login_user'];

// query for user information
$result = query_userInformationWithUsername($user_check);

// get user's id
$userid_result = $result['userid'];
$userid_trim=  trim($userid_result);
$_SESSION['userId'] = $userid_trim;
$user_userid = $userid_trim;

// get user's name
$name_result = $result['name'];
$name_trim = trim($name_result);
$_SESSION['userName'] = $name_trim;
$user_name = $name_trim;

// get user's location
$location_result = $result['location'];
$location_trim = trim($location_result);
$_SESSION['userlocation'] = $location_trim;
$user_location = $location_trim;

// get user's age
$age_result = $result['age'];
$age_trim = trim($age_result);
$_SESSION['userAge'] = $age_trim;
$user_age = $age_trim;

// get user's gender
$gender_result = $result['gender'];
$gender_trim = trim($gender_result);
$_SESSION['userGender'] = $gender_trim;
$user_gender = $gender_trim;

// get user's preference
$preference_result = $result['preference'];
$preference_trim = trim($preference_result);
$_SESSION['preference'] = $preference_trim;
/* String Formatting */
if($preference_trim == 'mf'){
	$_SESSION['userInterest'] = "Men & Women";
}
else if($preference_trim == 'm'){
	$_SESSION['userInterest'] = "Men";
}
else if($preference_trim == 'f'){
	$_SESSION['userInterest'] = "Women";
}
else{
	$_SESSION['userInterest'] = " ";
}
$user_interest = $_SESSION['userInterest'];

if(!isset($user_name)){
	oci_commit($db_conn);
	oci_close($db_conn);
	header('Location: user_login.php'); // Redirecting To Home Pge
}

?>
