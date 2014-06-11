<?php
	//echo sys_get_temp_dir() . '\\' . $_FILES['articleimage']['name'];
	$imagename = $_FILES['articleimage']['name'];
	$imagetype = $_FILES['articleimage']['type'];
	$imagesize = $_FILES['articleimage']['size'];
	$date = date('YMd-his');
	move_uploaded_file($_FILES['articleimage']['tmp_name'], 'img/' . $date . '-' . $imagename);
	echo 'img/' . $date . '-' . $imagename;
?>