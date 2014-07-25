<?php
	require_once('silahis_backendsecurity.php');
	$idno = strip_tags(str_replace('\'', '\'\'', trim($_POST['idno'])));
	$positionID = strip_tags(str_replace('\'', '\'\'', trim($_POST['position_id'])));
	require_once('silahis_connectvars.php');
	include_once('Staff.php');
	$dbc = new Staff(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	$dbc->endStaffTerm($idno);
	$dbc->addNewStaff($idno, $positionID);
	echo 'AUSTRALIA';
?>