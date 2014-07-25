<?php 
	require_once('backend/silahis_connectvars.php');
    include('backend/Staff.php');
    $dbcStaff2 = new Staff(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $staff_id = $_SESSION['staff_id'];
    $position_name = $dbcStaff2->getCurrentPositionName($staff_id);
    if ($position_name != 'Adviser' && $position_name != 'Editor-In-Chief') 
    {
    	exit('<h1>Forbidden Santisimen</h1><p>Access is denied.</p>');
    }
?>