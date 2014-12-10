<?php
	error_reporting(-1);
ini_set('display_errors', 'On');

	//include('PasswordHash.php');
	require_once('silahis_connectvars.php');
	include_once('Staff.php');
	require_once('anti_csrf.php');

	$csrf = new AntiCSRF();

	session_start();
	$dbc = new Staff(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	$username = strip_tags(str_replace('\'', '\'\'', trim($_POST['username'])));
	$password = strip_tags(str_replace('\'', '\'\'', trim($_POST['password'])));
	$success = $dbc->login($username, $password);
	if ($csrf->check_valid('post', true) && $success['result']) 
	{
		$jTableResult = array();
		$jTableResult['result'] = "AUSTRALIA";
		$jTableResult['position'] = $success['position'];
		print json_encode($jTableResult);
	} 
	else 
	{
		$jTableResult = array();
		$jTableResult['result'] = "PHILIPPINES";
		print json_encode($jTableResult);
	}
?>