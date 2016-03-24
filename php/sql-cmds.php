<?php

//this tells the system that it's no longer just parsing 
//html; it's now parsing PHP

$success = True; //keep track of errors so it redirects the page only if there are no errors
$db_conn = OCILogon("ora_z2p8", "a37087129", "ug");

function executePlainSQL($cmdstr) { //takes a plain (no bound variables) SQL command and executes it
	//echo "<br>running ".$cmdstr."<br>";
	global $db_conn, $success;
	$statement = OCIParse($db_conn, $cmdstr); //There is a set of comments at the end of the file that describe some of the OCI specific functions and how they work

	if (!$statement) {
		echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
		$e = OCI_Error($db_conn); // For OCIParse errors pass the       
		// connection handle
		echo htmlentities($e['message']);
		$success = False;
	}

	$r = OCIExecute($statement, OCI_DEFAULT);
	if (!$r) {
		echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
		$e = oci_error($statement); // For OCIExecute errors pass the statementhandle
		echo htmlentities($e['message']);
		$success = False;
	}

	return $statement;
}

function executeBoundSQL($cmdstr, $list) {
	/* Sometimes a same statement will be excuted for severl times, only
	 the value of variables need to be changed.
	 In this case you don't need to create the statement several times; 
	 using bind variables can make the statement be shared and just 
	 parsed once. This is also very useful in protecting against SQL injection. See example code below for       how this functions is used */

	global $db_conn, $success;
	$statement = OCIParse($db_conn, $cmdstr);

	if (!$statement) {
		echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
		$e = OCI_Error($db_conn);
		echo htmlentities($e['message']);
		$success = False;
	}

	foreach ($list as $tuple) {
		foreach ($tuple as $bind => $val) {
			//echo $val;
			//echo "<br>".$bind."<br>";
			OCIBindByName($statement, $bind, $val);
			unset ($val); //make sure you do not remove this. Otherwise $val will remain in an array object wrapper which will not be recognized by Oracle as a proper datatype

		}
		$r = OCIExecute($statement, OCI_DEFAULT);
		if (!$r) {
			echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
			$e = OCI_Error($statement); // For OCIExecute errors pass the statementhandle
			echo htmlentities($e['message']);
			echo "<br>";
			$success = False;
		}
	}

}

/**
 * Hacky function to run a SQL script. The script cannot be terminated with a ;
 * Sorry guys
 *
 * Derek Chan - March 20 2016
 */
function runSQLScript($filename) {
	/* explode is equivalent to Java's 'String.split()' function */
	$cmds = explode(";", file_get_contents($filename));
	foreach ($cmds as &$sqlcmd) {
		executePlainSQL($sqlcmd);
		OCICommit($db_conn);
	}
}

function printTableAttrs($tablename) {

}

function printResult($result) { //prints results from a select statement
	echo "<br>Got data from table users:<br>";
	echo "<table>";

	$ncols = oci_num_fields($result);
	for ($i = 1; $i <= $ncols; $i++) {
		$colname = oci_field_name($result, $i);
		echo "<th><b>" . htmlentities($colname, ENT_QUOTES) . "</b><?/th>\n";
	}

	while (($row = oci_fetch_array($result, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
	    echo "<tr>\n";
	    foreach ($row as $item) {
	        echo "  <td>".($item !== null ? htmlentities($item, ENT_QUOTES):" ")."</td>\n";
	    }
	    echo "</tr>\n";
	}

	echo "</table>";

}

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

function debug_to_console( $data ) {

    if ( is_array( $data ) )
        $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
    else
        $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";

    echo $output;
}
/* OCILogon() allows you to log onto the Oracle database
     The three arguments are the username, password, and database
     You will need to replace "username" and "password" for this to
     to work. 
     all strings that start with "$" are variables; they are created
     implicitly by appearing on the left hand side of an assignment 
     statement */

/* OCIParse() Prepares Oracle statement for execution
      The two arguments are the connection and SQL query. */
/* OCIExecute() executes a previously parsed statement
      The two arguments are the statement which is a valid OCI
      statement identifier, and the mode. 
      default mode is OCI_COMMIT_ON_SUCCESS. Statement is
      automatically committed after OCIExecute() call when using this
      mode.
      Here we use OCI_DEFAULT. Statement is not committed
      automatically when using this mode */

/* OCI_Fetch_Array() Returns the next row from the result data as an  
     associative or numeric array, or both.
     The two arguments are a valid OCI statement identifier, and an 
     optinal second parameter which can be any combination of the 
     following constants:

     OCI_BOTH - return an array with both associative and numeric 
     indices (the same as OCI_ASSOC + OCI_NUM). This is the default 
     behavior.  
     OCI_ASSOC - return an associative array (as OCI_Fetch_Assoc() 
     works).  
     OCI_NUM - return a numeric array, (as OCI_Fetch_Row() works).  
     OCI_RETURN_NULLS - create empty elements for the NULL fields.  
     OCI_RETURN_LOBS - return the value of a LOB of the descriptor.  
     Default mode is OCI_BOTH.  */

define()
?>
