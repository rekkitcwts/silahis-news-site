<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

  // If the session vars aren't set, try to set them with a cookie
  if (!isset($_SESSION['staff_id'])) 
  {
     if (isset($_COOKIE['staff_id']) && isset($_COOKIE['staff_username']) && isset($_COOKIE['position_id'])) 
	   {
        $_SESSION['staff_id'] = $_COOKIE['staff_id'];
        $_SESSION['staff_username'] = $_COOKIE['staff_username'];
	      $_SESSION['position_id'] = $_COOKIE['position_id'];
      }
  }
?>
