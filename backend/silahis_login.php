<?php
	include('PasswordHash.php');
	require_once('silahis_connectvars.php');
	session_start();
	$dbc = pg_connect("host=".DB_HOST." user=".DB_USER." password=".DB_PASSWORD." dbname=".DB_NAME);
	$username = pg_escape_string($dbc, trim($_POST['username']));
	$password = pg_escape_string($dbc, trim($_POST['password']));
	// Check if the username exists
	$data = pg_query($dbc, "SELECT staff_position.staff_id, position.position_id, staff.staff_username, staff.staff_salt, staff.staff_password, position.position_name FROM staff_position INNER JOIN position USING (position_id) INNER JOIN staff USING (staff_id) WHERE staff.staff_username = '$username' AND staff_position.enddate IS NULL");
	$rows = pg_num_rows($data);
	if ($rows == 1)
	{
		// username found, OK
		$row = pg_fetch_assoc($data);
		$reconstructedHash = implode(":", array(PBKDF2_HASH_ALGORITHM, PBKDF2_ITERATIONS, $row['staff_salt'], $row['staff_password']));
		// echo $reconstructedHash;
		if ((validate_password($password, $reconstructedHash) == true) && !empty($row['position_id']))
		{
			// success! Set the cookies and sessions here!
			if (!isset($_SESSION['staff_id']))
			{
				$_SESSION['staff_id'] = $row['staff_id'];
				$_SESSION['position_id'] = $row['position_id'];
				$_SESSION['staff_username'] = $row['staff_username'];
			}
				setcookie('staff_id', $row['staff_id'], time() + (60 * 60 * 24 * 30));    // expires in 30 days
				setcookie('staff_username', $row['staff_username'], time() + (60 * 60 * 24 * 30));  // expires in 30 days
				setcookie('position_id', $row['position_id'], time() + (60 * 60 * 24 * 30));
			
			//echo 'AUSTRALIA';
			$jTableResult = array();
			$jTableResult['result'] = "AUSTRALIA";
			$jTableResult['position'] = $row['position_name'];
			print json_encode($jTableResult);
		}
		else
		{
			// error
			$jTableResult = array();
			$jTableResult['result'] = "PHILIPPINES";
			print json_encode($jTableResult);
		}
	}
	else
	{
		// returns error
		$jTableResult = array();
			$jTableResult['result'] = "PHILIPPINES";
			print json_encode($jTableResult);
	}
?>