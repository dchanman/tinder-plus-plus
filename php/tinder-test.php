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

<p>Insert values into tab1 below:</p>
<p><font size="2"> Number&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
Name</font></p>
<form method="POST" action="tinder-test.php">
<!--refresh page when submit-->

   <p><input type="text" name="insNo" size="6"><input type="text" name="insName" 
size="18">
<!--define two variables to pass the value-->
      
<input type="submit" value="insert" name="insertsubmit"></p>
</form>
<!-- create a form to pass the values. See below for how to 
get the values--> 

<p> Update the name by inserting the old and new values below: </p>
<p><font size="2"> Old Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
New Name</font></p>
<form method="POST" action="tinder-test.php">
<!--refresh page when submit-->

   <p><input type="text" name="oldName" size="6"><input type="text" name="newName" 
size="18">
<!--define two variables to pass the value-->
      
<input type="submit" value="update" name="updatesubmit"></p>
<input type="submit" value="run hardcoded queries" name="dostuff"></p>
</form>

<?php
  include 'sql-cmds.php';
?>

