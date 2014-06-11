<?php
	include_once('DBConnection.php');

	/*  Student table temporarily named "staff" due to unexpected design change
	 *
	 */

	class Student extends DBConnection
	{
		public function getLastName($idno)
		{
			return $this->get_var("SELECT staff_lname FROM staff WHERE staff_id = '$idno'");
		}

		public function getFirstName($idno)
		{
			return $this->get_var("SELECT staff_fname FROM staff WHERE staff_id = '$idno'");
		}

		public function getCourse($idno)
		{
			return $this->get_var("SELECT course FROM staff WHERE staff_id = '$idno'");
		}
	}
?>