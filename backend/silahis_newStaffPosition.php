<?php
	$idno = strip_tags(str_replace('\'', '\'\'', trim($_POST['idno'])));
	$positionID = strip_tags(str_replace('\'', '\'\'', trim($_POST['position_id'])));
	require_once('silahis_connectvars.php');
	include('Staff.php');
//	echo $idno;
	$dbc = new Staff(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	$dbc->addNewStaff($idno, $positionID);
	echo 'AUSTRALIA';
?>