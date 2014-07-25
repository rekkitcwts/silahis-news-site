<?php
	require_once('silahis_backendsecurity.php');

	$id_no = strip_tags(str_replace('\'', '\'\'', trim($_POST['idno'])));
	if (!preg_match('/^(GM-|\d{2})\d{2}-\d{4}$/', $id_no))
	{
		echo 'Illegal operation.';
		exit();
	}
	//echo $id_no;
	include_once('Staff.php');
	require_once('silahis_connectvars.php');
	$dbcStaff = new Staff(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	$dbcStaff->endStaffTerm($id_no);
	echo 'AUSTRALIA';
?>