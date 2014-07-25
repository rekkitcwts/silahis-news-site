<?php
	require_once('silahis_backendsecurity.php');
	include_once('Staff.php');
	require_once('silahis_connectvars.php');
	$dbc = new Staff(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
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