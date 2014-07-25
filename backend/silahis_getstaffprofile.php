<?php
	require_once('silahis_backendsecurity.php');
	$id_no = strip_tags(str_replace('\'', '\'\'', trim($_POST['idno'])));
	$status = '';

	if (!preg_match('/^(GM-|\d{2})\d{2}-\d{4}$/', $id_no))
	{
		echo 'Illegal operation.';
		exit();
	}

	include('Student.php');
	include_once('Staff.php');
	require_once('silahis_connectvars.php');
	$dbc = new Student(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	$dbcStaff = new Staff(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	if ($dbcStaff->isActive($id_no) == false)
	{
		$status = 'Inactive';
	}
	else
	{
		$status = 'Active';
	} 
	$info = array();
	$info['idno'] = $id_no;
	$info['lname'] = $dbc->getLastName($id_no);
	$info['fname'] = $dbc->getFirstName($id_no);
	$info['course'] = $dbc->getCourse($id_no);
	$info['is_active'] = $status;
	$info['curposition'] = $dbcStaff->getCurrentPositionName($id_no);
	$info['positions'] = $dbcStaff->getAllPositions($id_no);
	print json_encode($info);
?>