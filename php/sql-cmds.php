<?php

//this tells the system that it's no longer just parsing 
//html; it's now parsing PHP

include 'credentials.php';

$success = True; //keep track of errors so it redirects the page only if there are no errors
$db_conn = OCILogon("ora_".$csid, "a".$studentnum, "ug");
$e;

function executePlainSQL($cmdstr) { //takes a plain (no bound variables) SQL command and executes it
	//echo "<br>running ".$cmdstr."<br>";
	global $db_conn, $success, $e;
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

function executePlainSQL_errReturn($cmdstr) { //takes a plain (no bound variables) SQL command and executes it
	//echo "<br>running ".$cmdstr."<br>";
	global $db_conn, $success, $e;
	$resultArr = array("SUCCESS"=>"1", "ERRCODE"=>"0");
	$statement = OCIParse($db_conn, $cmdstr); //There is a set of comments at the end of the file that describe some of the OCI specific functions and how they work
	
	if (!$statement) {
		$e = OCI_Error($db_conn); // For OCIParse errors pass the       
		// connection handle
		$resultArr["SUCCESS"] = 0;
		$resultArr["ERRCODE"] = $e['code'];
	}

	$r = OCIExecute($statement, OCI_DEFAULT);
	if (!$r) {
		$e = oci_error($statement); // For OCIExecute errors pass the statementhandle
		$resultArr['SUCCESS'] = 0;
		$resultArr['ERRCODE'] = $e['code'];
	}

	return $resultArr;
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
	return trim($row[USERNAME]);
}

function query_getNameFromId($id) {
	$result = executePlainSQL(
		"SELECT name FROM Users WHERE userid = '$id'"
	);

	$row = oci_fetch_array($result);
	return trim($row[NAME]);
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

function query_getSuccessfulMatchesOrderByMessageCount($userid) {
	$s = executePlainSQL(
		"SELECT Match.userid FROM (
			SELECT userid2 AS userid FROM successfulmatch WHERE userid1 = $userid
			UNION
			SELECT userid1 AS userid FROM successfulmatch WHERE userid2 = $userid
		) Match
		LEFT JOIN 
		(SELECT userid, messageChar FROM (
			SELECT senderUserID AS userid, messageChar FROM Message WHERE receiverUserID = $userid
			UNION ALL
			SELECT receiverUserID AS userid, messageChar FROM Message WHERE senderUserID = $userid)
		) Msgs
		ON Match.userid = Msgs.userid
		GROUP BY Match.userId
		ORDER BY COUNT(Msgs.messageChar) DESC"
		);

	$users_matches = array();
	while (($row = oci_fetch_array($s, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
	   	array_push($users_matches, $row[USERID]);
	}

	return $users_matches;	
}

function query_getSuccessfulMatchesOrderByCommonInterests($userid) {
	$s = executePlainSQL(
		"SELECT Match.userid FROM
			(SELECT userid2 AS userid FROM successfulmatch WHERE userid1 = $userid
			UNION
			SELECT userid1 AS userid FROM successfulmatch WHERE userid2 = $userid) Match
		INNER JOIN 
			(SELECT I1.userid, I1.interest FROM InterestedIn I1
			INNER JOIN InterestedIn I2
			ON I1.interest = I2.interest AND I1.userid <> $userid AND I2.userid = $userid) CommonInterests
		ON Match.userid = CommonInterests.userid
		GROUP BY Match.userid
		ORDER BY COUNT(*) DESC"
		);

	$users_matches = array();
	while (($row = oci_fetch_array($s, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
	   	array_push($users_matches, $row[USERID]);
	}

	return $users_matches;	
}

function query_getPerfectMatches($userid) {
	$s = executePlainSQL(

		"SELECT userid FROM Users U
		WHERE NOT EXISTS (
			SELECT interest FROM InterestedIn I
			WHERE I.userid = $userid
			AND NOT EXISTS (
				SELECT interest FROM InterestedIn I2
				WHERE I2.userid = U.userid
				AND I.interest = I2.interest
			)
		)
		INTERSECT
		(
			SELECT userid2 AS userid FROM successfulmatch WHERE userid1 = $userid
			UNION
			SELECT userid1 AS userid FROM successfulmatch WHERE userid2 = $userid
		)"
		);

	$users_matches = array();
	while (($row = oci_fetch_array($s, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
	   	array_push($users_matches, $row[USERID]);
	}

	return $users_matches;
}

function insert_addNewUser($username, $name, $location, $age, $gender, $preference, $password) {
	$result = executePlainSQL_errReturn(
		"INSERT INTO users VALUES (
			UserIDSequence.nextval,
			'$username',
			'$name',
			SYSDATE,
			'$location',
			$age,
			'$gender',
			'$preference',
			'$password')"
		);
	return $result;
}

function delete_user($userid) {
	$result = executePlainSQL_errReturn(
		"DELETE FROM Users WHERE userid = $userid"
		);

	return $result;
}

function delete_business($businessid) {
	$result = executePlainSQL_errReturn(
		"DELETE FROM Business WHERE businessid = $businessid"
		);

	return $result;
}

function insert_addNewBusiness($username, $location, $password) {
	$result = executePlainSQL_errReturn(
		"INSERT INTO Business VALUES (
			BusinessIDSequence.nextval,
			'$username',
			'$location', 
			'$password')"
		);

	return $result;
}

function insert_sendMessage($src_userid, $dest_userid, $msg_str) {
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

function query_userLocationFromId($userId){
	$result = executePlainSQL(
		"SELECT location FROM Users U
		WHERE U.UserID = '$userId'"
		);

	$row = oci_fetch_array($result);

	return trim($row[LOCATION]);

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

function query_businessInformationWithUsername($businessname) {
	/* Get user information */
	$result = executePlainSQL(
		"SELECT * FROM Business B
		WHERE B.businessname = '$businessname'"
	);

	$row = oci_fetch_array($result, OCI_ASSOC+OCI_RETURN_NULLS);

	$images = array();

	$returntuple = array(
		"id" => $row[BUSINESSID],
		"name" => $row[BUSINESSNAME],
		"location" => $row[LOCATION],
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

	return $images;
}

function insert_image($userid, $url, $displayorder) {
	/* INSERT into Match, or UPDATE if entry exists */
	$result = executePlainSQL(
		"BEGIN
		  INSERT INTO Image VALUES ($userid, SYSDATE, '$url', $displayorder);
		EXCEPTION
		  WHEN DUP_VAL_ON_INDEX THEN
		    UPDATE Image
		    SET    imageurl = '$url', dateadded = SYSDATE
		    WHERE userid = $userid AND displayorder = $displayorder;
		END;"
	);
}

function query_getUserInterests($userid1) {
	$result = executePlainSQL(
		"SELECT interest FROM InterestedIn WHERE userID = $userid1"
	);

	$interests = array();

	while (($row = oci_fetch_array($result, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
	    array_push($interests, trim($row[INTEREST]));
	}

	return $interests;
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

function query_getPremiumUnmatchedusers($userid) {
	$s = executePlainSQL(

		"SELECT userid FROM Users U
		WHERE NOT EXISTS (
			SELECT interest FROM InterestedIn I
			WHERE I.userid = $userid
			AND NOT EXISTS (
				SELECT interest FROM InterestedIn I2
				WHERE I2.userid = U.userid
				AND I.interest = I2.interest
			)
		)
		INTERSECT (
			SELECT U2.userid
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
			)
		)"
		);

	$unmatchedUsers = array();
	while (($row = oci_fetch_array($s, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
	   	array_push($unmatchedUsers, $row[USERID]);
	}

	$returntuple = array(
		"unmatchedUsers" => $unmatchedUsers
		);

	return $returntuple;
}

function query_getActivitiesWithCompanyName($businessname) {
	$result = executePlainSQL(
		"SELECT * FROM Activity WHERE businessName = '$businessname'"
	);

	$activities = array();

	while (($row = oci_fetch_array($result, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
		$activity = array(
			"activity" => trim($row[ACTIVITY]),
			"businessName" => trim($row[BUSINESSNAME]),
			"scheduledTime" => trim($row[SCHEDULEDTIME]),
			"interestType" => trim($row[INTERESTTYPE]),
			"discount" => trim($row[DISCOUNT])
			);
	    array_push($activities, $activity);
	}

	return $activities;
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

function update_userProfile($userid, $name, $location, $age, $gender, $preference) {
	/* INSERT into Match, or UPDATE if entry exists */
	$result = executePlainSQL(
		"UPDATE Users
		SET name = '$name',
		location = '$location',
		age = '$age',
		gender = '$gender',
		preference = '$preference'
		WHERE userid = $userid"
	);
}

function update_businessProfile($businessid, $location) {
	/* INSERT into Match, or UPDATE if entry exists */
	$result = executePlainSQL(
		"UPDATE Business
		SET location = '$location'
		WHERE businessid = $businessid"
	);
}

 function update_activity($businessName, $oldActivity, $oldScheduledTime, $activity, $scheduledTime, $discount, $interestType) {
 	$result = executePlainSQL(
		"UPDATE Activity
		SET activity = '$activity',
		scheduledTime = '$scheduledTime',
		discount = '$discount',
		interestType = '$interestType'
		WHERE businessName = '$businessName' AND
		activity = '$oldActivity' AND
		scheduledTime = '$oldScheduledTime'"
	);
 }

 function insert_activity($businessname, $activity, $scheduledTime, $discount, $interestType) {
	$result = executePlainSQL(
			"INSERT INTO Activity VALUES (
				'$activity',
				'$businessname',
				'$scheduledTime',
				'$interestType',
				$discount)"
			);

		return $result;
 }

 function delete_activity($businessname, $activity, $scheduledTime) {
 	$result = executePlainSQL(
		"DELETE FROM Activity 
			WHERE businessName = '$businessname' AND
			activity = '$activity' AND
			scheduledTime = '$scheduledTime'"	
 		);

 	return $result;
 }

function query_getInterests() {
	$result = executePlainSQL(
		"SELECT interestType FROM Interest ORDER BY interestType ASC"
	);

	$interests = array();

	while (($row = oci_fetch_array($result, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
	    array_push($interests, trim($row[INTERESTTYPE]));
	}

	return $interests;
}

function query_getScheduledTimes() {
	$result = executePlainSQL(
		"SELECT scheduledTime FROM scheduledTimes ORDER BY scheduledTime ASC"
	);

	$times = array();

	while (($row = oci_fetch_array($result, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
	    array_push($times, trim($row[SCHEDULEDTIME]));
	}

	return $times;
}

function insert_userInterest($userid, $interest) {
	$result = executePlainSQL(
		"BEGIN
			INSERT INTO InterestedIn VALUES ($userid, '$interest');
		EXCEPTION
			WHEN DUP_VAL_ON_INDEX THEN RETURN;
		END;"
	);

	return $result;
}

function remove_userInterest($userid, $interest) {
	$result = executePlainSQL(
		"DELETE FROM InterestedIn 
			WHERE userid = $userid AND interest = '$interest'"
	);

	return $result;
}

function query_getConversation($myid, $otheruser) {
	$result = executePlainSQL(
		"SELECT senderUserId, messageChar FROM Message
		WHERE (senderUserId = $myid AND receiverUserId = $otheruser) OR
		(senderUserId = $otheruser AND receiverUserId = $myid)
		ORDER BY messageId ASC"
	);

	$convo = array();

	while (($row = oci_fetch_array($result, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
		$msg = array(
			"sender" => trim($row[SENDERUSERID]),
			"message" => trim($row[MESSAGECHAR])
			);
	    array_push($convo, $msg);
	}

	return $convo;
}

function query_getLocations() {
	$result = executePlainSQL(
		"SELECT location FROM Locations ORDER BY location ASC"
	);

	$locations = array();

	while (($row = oci_fetch_array($result, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
	    array_push($locations, trim($row[LOCATION]));
	}

	return $locations;
}

function query_getActivitiesBasedOnInterestType($interesttype){
	$result = executePlainSQL(
		"SELECT Activity FROM Activity WHERE interesttype = $interesttype"
	);

	$activities = array();

	while (($row = oci_fetch_array($result, OCI_ASSOC+OCI_RETURN_NULLS)) != false){
		array_push($activities, trim($row[ACTIVITY]));
	}

	return $activities;

}

function query_getActivitiesSelectAndFilter($activityProjection, $interestSelection) {
 	$result = executePlainSQL(
 		"SELECT $activityProjection FROM Activity A
 		INNER JOIN Business B ON A.BusinessName = B.BusinessName
  		WHERE $interestSelection"
 	);
 
 	$results = array();
 	while (($row = oci_fetch_array($result, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
 		$resultItem = array(
 			"activity" => trim($row[ACTIVITY]),
 			"businessName" => trim($row[BUSINESSNAME]),
 			"location" => trim($row[LOCATION]),
 			"interestType" => trim($row[INTERESTTYPE]),
 			"scheduledTime" => trim($row[SCHEDULEDTIME]),
 			"discount" => trim($row[DISCOUNT])
 			);
 		array_push($results, $resultItem);
 	}
  
 	return $results;
  }

function query_getActivitiesBasedOnTime($scheduledTime){
	$result = executePlainSQL(
		"SELECT Activity
		FROM Activity
		WHERE scheduledTime = '$scheduledTime'"
		);

	$activities =  array();

	while(($row = oci_fetch_array($result, OCI_ASSOC+OCI_RETURN_NULLS)) != false){
		array_push($activities, trim($row[ACTIVITY]));
	}

	return $activities;
}

function query_getActivitiesBasedOnLocation($businessLocation){
	$result = executePlainSQL(
		"SELECT Activity
		FROM Activity A
		WHERE A.businessname IN (
			SELECT B.businessname
			FROM Business B
			WHERE location = '$businessLocation')"
	);

	$locations =  array();

	while(($row = oci_fetch_array($result, OCI_ASSOC+OCI_RETURN_NULLS)) != false){
		array_push($locations, trim($row[BUSINESSNAME]));
	}

	return $locations;
}

function delete_photo($userid, $displayorder){

	$result = executePlainSQL(
		"DELETE FROM Image
		WHERE userid = '$userid' AND displayorder = '$displayorder'"
		);
	
	return $result;
}

function mostPopularInterestTypeAtLocation($location){

	$result = executePlainSQL(
		"WITH InterestCount AS(
			SELECT interest, COUNT(*) AS count
			FROM (
				SELECT interest FROM InterestedIn I
				INNER JOIN Users U On I.userId = U.userId
				WHERE U.location = '$location'
				) GROUP BY interest
			)
		SELECT interest FROM InterestCount
		WHERE count = (
			SELECT MAX(count)
			FROM InterestCount
		)"
	);

	$interests = array();
	while(($row = oci_fetch_array($result, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
		array_push($interests, trim($row[INTEREST]));
	}
		
	return $interests;
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
