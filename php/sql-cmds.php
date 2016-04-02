<?php

//this tells the system that it's no longer just parsing 
//html; it's now parsing PHP

include 'credentials.php';

$success = True; //keep track of errors so it redirects the page only if there are no errors
$db_conn = OCILogon("ora_".$csid, "a".$studentnum, "ug");

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

		/* Ignore comments */
		if (preg_match('([#])', $sqlcmd)) {
			continue;
		}

		if (preg_match('([a-zA-Z])', $sqlcmd)) {
			executePlainSQL($sqlcmd);
		}
	}
}

function printTable($table) {
	$result = executePlainSQL("select * from $table");
	echo "<br>Got data from table $table:<br>";
	printResult($result);
}

/* Prints results from a select statement */
function printResult($result) {
	echo "<table>";

	$ncols = oci_num_fields($result);
	for ($i = 1; $i <= $ncols; $i++) {
		$colname = oci_field_name($result, $i);
		echo "<th><b>" . htmlentities($colname, ENT_QUOTES) . "</b></th>\n";
	}

	while (($row = oci_fetch_array($result, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
	    echo "<tr>\n";
	    foreach ($row as $item) {
	        echo "  <td>".($item !== null ? htmlentities($item, ENT_QUOTES) : "(null)")."</td>\n";
	    }
	    echo "</tr>\n";
	}

	echo "</table>";

}


/******************************************************************************
 *
 * ALL SQL QUERIES/COMMANDS ARE LOCATED BELOW
 *
 *****************************************************************************/

function query_getIdFromUsername($username) {
	$result = executePlainSQL(
		"SELECT userid FROM users WHERE username = '$username'"
	);

	$row = oci_fetch_array($result);
	return $row[0];
}

function query_getUsernameFromId($id) {
	$result = executePlainSQL(
		"SELECT username FROM Users WHERE userid = '$id'"
	);

	$row = oci_fetch_array($result);
	return $row[USERNAME];
}

function query_getSuccessfulMatches($userid) {
	$s = executePlainSQL(
		"SELECT userid2 AS userid FROM successfulmatch WHERE userid1 = '$userid'
		UNION
		SELECT userid1 AS userid FROM successfulmatch WHERE userid2 = '$userid'"
		);

	$users_matches = array();
	while (($row = oci_fetch_array($s, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
	   	array_push($users_matches, $row[USERID]);
	}

	return $users_matches;
}

function insert_sendMessage($src_userid, $dest_userid, $msg_str){
	$result = executePlainSQL(
		"INSERT INTO Message VALUES (
			MessageIDSequence.nextval,
			'$src_userid',
			'$dest_userid',
			'$msg_str',
			SYSDATE)"
		);

	return $result;
}

function query_userInformationWithUserID($userid) {
	/* Get user information */
	$result = executePlainSQL(
		"SELECT * FROM Users U
		WHERE U.userid = $userid"
	);

	$row = oci_fetch_array($result, OCI_ASSOC+OCI_RETURN_NULLS);
	$name = $row[NAME];
	$age = $row[AGE];

	$images = array();

	$returntuple = array(
		"userid" => $row[USERID],
		"name" => $row[NAME],
		"age" => $row[AGE],
		"location" => $row[LOCATION],
		"gender" => $row[GENDER],
		"preference" => $row[PREFERENCE],
		);

	return $returntuple;
}

function query_userInformationWithUsername($username) {
	/* Get user information */
	$result = executePlainSQL(
		"SELECT * FROM Users U
		WHERE U.username = '$username'"
	);

	$row = oci_fetch_array($result, OCI_ASSOC+OCI_RETURN_NULLS);
	$name = $row[NAME];
	$age = $row[AGE];

	$images = array();

	$returntuple = array(
		"userid" => $row[USERID],
		"name" => $row[NAME],
		"age" => $row[AGE],
		"location" => $row[LOCATION],
		"gender" => $row[GENDER],
		"preference" => $row[PREFERENCE],
		);

	return $returntuple;
}

function query_images($userid) {
	/* Get user's images */
	$result = executePlainSQL(
		"SELECT imageurl FROM Image I
		WHERE userid = $userid
		ORDER BY displayorder"
	);

	$images = array();

	while (($row = oci_fetch_array($result, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
	    array_push($images, $row[IMAGEURL]);
	}

	$returntuple = array(
		"images" => $images,
		);

	return $returntuple;
}

function query_getInterests($userid1) {
	$result = executePlainSQL(
		"SELECT interest FROM InterestedIn WHERE userID = $userid1"
	);

	$interests = array();

	while (($row = oci_fetch_array($result, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
	    array_push($interests, $row[INTEREST]);
	}

	$returntuple = array(
		"interests" => $interests
		);

	return $returntuple;
}

function query_getCommonInterests($userid1, $userid2) {
	$result = executePlainSQL(
		"SELECT interest FROM InterestedIn WHERE userID = $userid1
		INTERSECT
		SELECT interest FROM InterestedIn WHERE userID = $userid2"
	);


	$commonInterests = array();

	while (($row = oci_fetch_array($result, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
	    array_push($commonInterests, $row[INTEREST]);
	}

	$returntuple = array(
		"commonInterests" => $commonInterests
		);

	return $returntuple;
}

function query_getUnmatchedUsers($userid) {
	$result = executePlainSQL(
		"SELECT U2.userid
		FROM Users U1 INNER JOIN Users U2
		ON
		U1.userid = $userid AND
		U1.preference LIKE '%' || U2.gender || '%' AND
		U2.preference LIKE '%' || U1.gender || '%' AND
		U1.userid <> U2.userid
		WHERE
		NOT EXISTS (
			SELECT matcher, matchee
			FROM Match
			WHERE matcher = $userid AND matchee = U2.userid
		)"
	);

	$unmatchedUsers = array();

	while (($row = oci_fetch_array($result, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
	    array_push($unmatchedUsers, $row[USERID]);
	}

	$returntuple = array(
		"unmatchedUsers" => $unmatchedUsers
		);

	return $returntuple;
}

function query_businessInformationWithUsername($username) {
	/* Get user information */
	$result = executePlainSQL(
		"SELECT * FROM Business B
		WHERE B.username = '$username'"
	);

	$row = oci_fetch_array($result, OCI_ASSOC+OCI_RETURN_NULLS);
	$name = $row[LOCATION];

	$images = array();

	$returntuple = array(
		"id" => $row[BUSINESSID],
		"name" => $row[BUSINESSNAME],
		"location" => $row[LOCATION],
	);

	return $returntuple;
}

function insert_match($matcherUserID, $matcheeUserID, $match) {
	/* INSERT into Match, or UPDATE if entry exists */
	$result = executePlainSQL(
		"BEGIN
		  INSERT INTO Match VALUES ($matcherUserID, $matcheeUserID, '$match');
		EXCEPTION
		  WHEN DUP_VAL_ON_INDEX THEN
		    UPDATE Match
		    SET    match = '$match'
		    WHERE matcher = $matcherUserID AND matchee = $matcheeUserID;
		END;"
	);
}

function update_userProfile($userid, $username, $name, $location, $age, $gender, $preference) {
	/* INSERT into Match, or UPDATE if entry exists */
	$result = executePlainSQL(
		"UPDATE Users
		SET username = '$username',
		name = '$name',
		location = '$location',
		age = '$age',
		gender = '$gender',
		preference = '$preference'
		WHERE userid = $userid"
	);
}

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
