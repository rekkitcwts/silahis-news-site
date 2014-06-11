<?php
	include('Staff.php');
	require_once('silahis_connectvars.php');
	$dbc = new Staff(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	// Trim, escape, strip tags.
/*	$firstName = strip_tags(str_replace('\'', '\'\'', trim($_POST['firstname'])));
	$lastName = strip_tags(str_replace('\'', '\'\'', trim($_POST['lastname'])));
	$position = strip_tags(str_replace('\'', '\'\'', trim($_POST['positionId'])));
	$username = strip_tags(str_replace('\'', '\'\'', trim($_POST['username'])));
	$password = strip_tags(str_replace('\'', '\'\'', trim($_POST['password'])));
	if ($dbc->usernameAvailableChecker($username) == false) // not available
	{
		echo "USERNAME TAKEN";
	}
	else
	{
		$newStaff = array('firstname' => $firstName, 'lastname' => $lastName, 'positionId' => $position, 'username' => $username, 'password' => $password);
		$dbc->addNewStaff($newStaff);
		echo "ADD SUCCESSFUL";
	} */
	$idnumber = strip_tags(str_replace('\'', '\'\'', trim($_POST['idnumber'])));
	$positionID = strip_tags(str_replace('\'', '\'\'', trim($_POST['position_id'])));
	if (!preg_match('/^(GM-|\d{2})\d{2}-\d{4}$/', $idnumber))
	{
		echo 'INVALID_ID_NUM';
	}
	else
	{
		$dbc->addNewStaff($idnumber, $positionID);
		echo 'AUSTRALIA';
	}
?>