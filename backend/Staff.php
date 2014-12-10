<?php
	include('PasswordHash.php'); // uses PBKDF2 algorithm
	include_once('DBConnection.php');

	class Staff extends DBConnection
	{
		public function addNewStaff($staff_id, $position_id)
		{
			$this->query("INSERT INTO staff_position (staff_id, position_id) VALUES ('$staff_id','$position_id')");
		}

		public function endStaffTerm($staff_id)
		{
			$currentDate = date('Y-m-d');
			$sp_id = $this->get_var("SELECT sp_id FROM staff_position WHERE staff_id = '$staff_id' AND enddate IS NULL");
			//$this->query("UPDATE staff_position SET enddate = now() WHERE sp_id = $sp_id");
			$this->query("UPDATE staff_position SET enddate = now() WHERE sp_id = $sp_id");
		}

		public function isActive($staff_id)
		{
			$flag = $this->get_var("SELECT COUNT(*) AS flag FROM staff_position WHERE staff_id = '$staff_id' AND enddate IS NULL");
			if ($flag > 0) return true;
			else return false;
		}

		public function login($username, $password)
		{
			$user = $this->get_row("SELECT staff_position.staff_id, position.position_id, staff.staff_username, staff.staff_salt, staff.staff_password, position.position_name FROM staff_position INNER JOIN position USING (position_id) INNER JOIN staff USING (staff_id) WHERE staff.staff_username = '$username' AND staff_position.enddate IS NULL");
			if ($user['staff_username'] != '') 
			{
				$reconstructedHash = implode(":", array(PBKDF2_HASH_ALGORITHM, PBKDF2_ITERATIONS, $user['staff_salt'], $user['staff_password']));
				if ((validate_password($password, $reconstructedHash) == true) && !empty($user['position_id']))
				{
			// success! Set the cookies and sessions here!
			if (!isset($_SESSION['staff_id']))
			{
				$_SESSION['staff_id'] = $user['staff_id'];
				$_SESSION['position_id'] = $user['position_id'];
				$_SESSION['staff_username'] = $user['staff_username'];
			}
				setcookie('staff_id', $user['staff_id'], time() + (60 * 60 * 24 * 30));    // expires in 30 days
				setcookie('staff_username', $user['staff_username'], time() + (60 * 60 * 24 * 30));  // expires in 30 days
				setcookie('position_id', $user['position_id'], time() + (60 * 60 * 24 * 30));

				return array('result' => true, 'position' => $user['position_name']);
				}
				else
				{
					return false;
				}
			} 
			else 
			{
				return false;
			}
			
		}

		/* 
		 *  Data Structures "Getters and Setters"
		 */
		public function getCurrentPositionName($staff_id)
		{
			return $this->get_var("SELECT position.position_name FROM staff_position INNER JOIN position USING (position_id) WHERE staff_position.staff_id = '$staff_id'");
		}

		public function getAllPositions($staff_id)
		{
			return $this->get_results("SELECT position.position_name, staff_position.startdate, staff_position.enddate FROM staff_position INNER JOIN position USING (position_id) WHERE staff_position.staff_id = '$staff_id' ORDER BY staff_position.startdate");
		}

		public function getPosition($staff_id)
		{
			return $this->get_var("SELECT position_id FROM staff_position WHERE staff_id = '$staff_id'");
		}

		public function setPosition($staff_id, $positionID)
		{
			$this->query("UPDATE staff_position SET position_id = '$positionID' WHERE staff_id = '$staff_id'");
		}

		public function getStartDate($staff_id)
		{
			return $this->get_var("SELECT startdate FROM staff_position WHERE staff_id = '$staff_id' AND enddate IS NULL");
		}

		// Deprecated functions start here...

		public function getUsername($staff_id)
		{
			return $this->get_var("SELECT staff_username FROM staff WHERE staff_id = '$staff_id'");
		}

		public function getPWhash($staff_id)
		{
			$salt = $this->get_var("SELECT staff_salt FROM staff WHERE staff_id = '$staff_id'");
			$hash = $this->get_var("SELECT staff_password FROM staff WHERE staff_id = '$staff_id'");
			// format - algo:iter:salt:hash
			return PBKDF2_HASH_ALGORITHM . ":" . PBKDF2_ITERATIONS . ":" .  $salt . ":" . $hash;
		}

		// ...and end here.
	}
?>