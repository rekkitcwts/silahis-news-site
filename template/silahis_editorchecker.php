<?php 
	require_once('backend/silahis_connectvars.php');
    include_once('backend/Staff.php');
    $dbcStaff = new Staff(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $staff_id = $_SESSION['staff_id'];
    $position_name_user = $dbcStaff->getCurrentPositionName($staff_id);
	if ($position_name_user != 'News Editor' && $position_name_user != 'Feature Editor' && $position_name_user != 'Associate Editor' && $position_name_user != 'Adviser' && $position_name_user != 'Editor-In-Chief') 
    {
    	exit('<h1>Forbidden Santisimen</h1><p>Access is denied.</p>');
    }
?>