<?php
	include_once('DBConnection.php');

	class Position extends DBConnection
	{
		public function getAllPositions()
		{
			return $this->get_results("SELECT * FROM position");
		}

		public function addPosition($position)
		{
			$this->query("INSERT INTO position (position_name) VALUES ('$position')");
		}
	}
?>