<?php

include ('sql-cmds.php');

$user_check = $_SESSION['login_user'];

$s = executePlainSQL("select userName
					 from Users 
					 where userName = '$user_check'");

$parse_result = oci_parse($db_conn, $s);
$result = oci_execute($parse_result);

$login_session =$result['username'];

?>