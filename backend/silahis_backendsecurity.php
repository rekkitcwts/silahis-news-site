<?php
error_reporting(-1);
ini_set('display_errors', 'On');

include_once('Staff.php');
require_once('silahis_connectvars.php');
$dbcStaffCheck = new Staff(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

session_start();

  // If the session vars aren't set, try to set them with a cookie
if (!isset($_SESSION['staff_id'])) 
{
    if (isset($_COOKIE['staff_id']) && isset($_COOKIE['staff_username']) && isset($_COOKIE['position_id']) && ($_COOKIE['staff_username'] == $dbcStaffCheck->getUsername($_COOKIE['staff_id'])) && ($dbcStaffCheck->isActive($_COOKIE['staff_id']) === true)) 
	{
        $_SESSION['staff_id'] = $_COOKIE['staff_id'];
        $_SESSION['staff_username'] = $_COOKIE['staff_username'];
	      $_SESSION['position_id'] = $_COOKIE['position_id'];
    }
    else
    {
    	header('Location: staff_login.php');
		exit();
    }
}
?>