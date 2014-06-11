<?php
	require_once('silahis_connectvars.php');
	include('Position.php');

	$dbc = new Position(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

	print json_encode($dbc->getAllPositions());
?>