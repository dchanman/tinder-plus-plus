<?php

include 'credentials.php';
include 'sql-cmds.php';

ini_set('session.save_path', $cshomedir.'/public_html/php_sessions');
session_start();

$db_conn = OCILogon("ora_".$csid, "a".$studentnum, "ug");

$businessusername = $_SESSION['login_business'];

// query for user information
$result = query_userInformationWithUsername($business_username);

// get user's id
$business_id_result = $result['business_id'];
$business_id_trim=  trim($business_id_result);
$_SESSION['business_id'] = $business_id_trim;
$business_id = $business_id_trim;
global $business_id;


// get user's location
$business_location_result = $result['business_location'];
$business_location_trim = trim($business_location_result);
$_SESSION['business_location'] = $business_location_trim;
$business_location = $business_location_trim;
global $business_location;

if(!isset($business_id)){
	oci_commit($db_conn);
	oci_close($db_conn);
	header('Location: business_login.php'); // Redirecting To Home Pge
}

?>
