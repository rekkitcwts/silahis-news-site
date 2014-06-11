<?php
	if (!(($row['position_name'] == "Adviser") && ($row['position_name'] == "Editor-In-Chief")))
	{
		header('Location: writer_desk.php');
		exit();
	}
?>