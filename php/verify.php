<?php 
include 'credentials.php';
include 'sql-cmds.php';

ini_set('session.save_path', $cshomedir.'/public_html/php_sessions');
session_start();

$error=''; // Variable To Store Error Message
if (isset($_POST['UserLogin'])) {
    if (empty($_POST['userName']) || empty($_POST['userPwd'])) {
        $error = "Username or Password cannot be empty";
    }

    // else if (empty($_POST['businessName']) || empty($_POST['businessPwd'])) {
    //  $error = "Business Name or Password is invalid";
    // }

    else{

        // connect to DB
        //$db_conn = OCILogon("ora_n4u8", "a38777124", "ug");
        $db_conn = OCILogon("ora_".$csid, "a".$studentnum, "ug");
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
 
            if($result[0]==1){
               echo "Valid username / password";
               $_SESSION['login_user']= $inputname; // Initializing Session
               header("location: user_profile.php"); // Redirecting To Other Page
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

if(isset($_POST['BusinessLogin'])){
    if (empty($_POST['businessName']) || empty($_POST['businessPwd'])) {
        $error = "Business Name or Password is invalid";
    }
    else{

        // connect to DB
        $db_conn = OCILogon("ora_".$csid, "a".$studentnum, "ug");

        // now connected
        if ($db_conn) {

            // grab the information needed for login
            $inputname = $_POST['businessName'];
            $inputpwd = $_POST['businessPwd'];
        
            // query for information obtained
            $s = executePlainSQL("select count (*)
                           from Business 
                          where BusinessName = '$inputname' AND 
                          PasswordHash = '$inputpwd'");
 
            $result = oci_fetch_array($s);
 
            if($result[0]==1){
               $_SESSION['login_business']= $inputname; // Initializing Session
               header("location: business_profile.php"); // Redirecting To Other Page
            }
            else{
             $error = "Business Name or Password is invalid";
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
