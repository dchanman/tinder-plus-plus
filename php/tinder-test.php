<!--Test Oracle file for UBC CPSC304 2011 Winter Term 2
  Created by Jiemin Zhang
  Modified by Simona Radu
  Further modified by Derek Chan, Emmett Tan, Peter Chung
  This file shows the very basics of how to execute PHP commands
  on Oracle.  
  specifically, it will drop a table, create a table, insert values
  update values, and then query for values
 
  IF YOU HAVE A TABLE CALLED "tab1" IT WILL BE DESTROYED

  The script assumes you already have a server set up
  All OCI commands are commands to the Oracle libraries
  To get the file to work, you must place it somewhere where your
  Apache server can run it, and you must rename it to have a ".php"
  extension.  You must also change the username and password on the 
  OCILogon below to be your ORACLE username and password -->

<p>If you wish to reset the table press on the reset button. If this is the first time you're running this page, you MUST use reset</p>
<form method="POST" action="tinder-test.php">
   
<p><input type="submit" value="Reset" name="reset"></p>
</form>

<input type="submit" value="Generate Sample Data" name="dostuff"></p>
</form>

<?php
  include 'sql-cmds.php';

  // Connect Oracle...
if ($db_conn) {

  if (array_key_exists('reset', $_POST)) {
    // Drop old table and create new one
    echo "<br> dropping table, creating new tables... <br>";
    runSQLScript('sql/schema.sql');

  } else if (array_key_exists('insertsubmit', $_POST)) {
      //Getting the values from user and insert data into the table
      $tuple = array (
        ":bind1" => $_POST['insNo'],
        ":bind2" => $_POST['insName']
      );
      $alltuples = array (
        $tuple
      );
      executeBoundSQL("insert into tab1 values (:bind1, :bind2)", $alltuples);
      OCICommit($db_conn);

  } else if (array_key_exists('updatesubmit', $_POST)) {
    // Update tuple using data from user
    $tuple = array (
      ":bind1" => $_POST['oldName'],
      ":bind2" => $_POST['newName']
    );
    $alltuples = array (
      $tuple
    );
    executeBoundSQL("update tab1 set name=:bind2 where name=:bind1", $alltuples);
    OCICommit($db_conn);

  } else if (array_key_exists('dostuff', $_POST)) {
    // Insert data into table...
    echo "inserting sample data into db...";
    runSQLScript('sql/sample.sql');
    OCICommit($db_conn);
  } else if (array_key_exists('login', $_POST)) {
    echo "logging in...";
    
    $user = array(
      'userid' => $id,
      'username' => $username,
      'login' => $login,
    );
    setcookie("loginCredentials", $user, time() * 7200);
  } else if (array_key_exists('signup', $_POST)) {
    // Drop old table...
    $tuple = array (
      ":username_text" => $_POST['username_text'],
      ":name_text" => $_POST['name_text'],
      ":password_text" => $_POST['password_text'],
      ":confirm_password_text" => $_POST['confirm_password_text'],
      ":password_hash" => '',
      ":username_text" => $_POST['username_text'],
      ":gender" => $_POST['gender'],
      ":age_text" => $_POST['age_text'],
      ":location_text" => $_POST['location_text'],
      ":interestedInMen" => $_POST['interestedInMen'],
      ":interestedInWomen" => $_POST['interestedInWomen'],
      ":date_joined" => date("m.d.Y")
      //date("m.d.y")
    );

    if($tuple[':password_text'] != $tuple[':confirm_password_text']){
      echo "Passwords don't match";
      printResult($result);
      return;
    }

    if($tuple[':interestedInMen'] == NULL && $tuple[':interestedInWomen'] == NULL){
      echo "Must pick interest";
      printResult($result);
      return;
    }

    $tuple[':password_hash'] = crypt($tuple[':password_text']);
    //password_hash($tuple[':password_text'], PASSWORD_DEFAULT);

    $alltuples = array (
      $tuple
    );

    /* UserIDSequence.nextval automatically gets the next available user ID for us from the database */
    /* Note that if the insert fails, we still increment the sequence... lol */
    executeBoundSQL("INSERT INTO users VALUES (UserIDSequence.nextval, :username_text, :name_text, :date_joined, :location_text, :age_text, :gender, :interestedInMen, :interestedInWomen, :password_hash)", $alltuples);

    // Create new table...
    echo "<br> creating new user <br>";
    OCICommit($db_conn);
  }else if(array_key_exists('updateLoc', $_POST)){
    $tuple = array(
      // assuming the profile page is already implemented and input name for new location is newLoc
      ":bind1" => $_POST['userID'],
      ":bind2" => $_POST['newLoc']
      );
    $alltuples = array(
      $tuple
      );
    executeBoundSQL("update Users set location=:bind2 where userID=:bind1", $alltuples);
    OCICommit($db_conn);
  }

  if ($_POST && $success) {
    //POST-REDIRECT-GET -- See http://en.wikipedia.org/wiki/Post/Redirect/Get
    $page = $_SERVER['PHP_SELF'];
    $sec = "1";
    header("Refresh: $sec; url=$page");
  } else {
    // Select data...
    $result = executePlainSQL("select * from Users");
  }

  //Commit to save changes...
  OCILogoff($db_conn);
} else {
  echo "cannot connect";
  $e = OCI_Error(); // For OCILogon errors pass no handle
  echo htmlentities($e['message']);
}
printResult($result);

printTable('users');
//printTable('image');
?>

