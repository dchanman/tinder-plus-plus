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
<p><input type="submit" value="Generate Sample Data" name="dostuff"></p>

</form>

<?php
  include 'credentials.php';
  include 'sql-cmds.php';

  echo "<br>Your credentials: " . $csid . " (" . $studentnum . ")</br>";

  if ($db_conn) {

    if (array_key_exists('reset', $_POST)) {
      // Drop old table and create new one
      echo "<br> dropping table, creating new tables... <br>";
      runSQLScript('sql/schema.sql');
      
    } else if (array_key_exists('dostuff', $_POST)) {
      // Insert data into table...
      echo "<br>inserting sample data into db...<br>";
      runSQLScript('sql/sample.sql');
    }

    printTable('users');
    printTable('image');

    /* Commit to save changes... */
    OCICommit($db_conn);

    /* LOG OFF WHEN YOU'RE DONE! */
    OCILogoff($db_conn);

  } else { /* if ($db_conn) */
    echo "cannot connect";
    $e = OCI_Error(); // For OCILogon errors pass no handle
    echo htmlentities($e['message']);
  }
?>

