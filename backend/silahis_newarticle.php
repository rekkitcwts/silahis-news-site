<?php
	require_once('silahis_backendsecurity.php');
	$errors = array();
	$status = "";
	require_once('silahis_connectvars.php');
	require_once('../template/silahis_sessionstarter.php');
	$dbc = pg_connect("host=".DB_HOST." user=".DB_USER." password=".DB_PASSWORD." dbname=".DB_NAME);
	$author = $_SESSION['staff_id'];
	$title = strip_tags(pg_escape_string($dbc, trim($_POST['title'])));
	$articleTypeID = $_POST['articleselection'];
	$articleBody = trim($_POST['articlebody']);
	$imagename = pg_escape_string($dbc, trim($_FILES['articleimage']['name']));
	$imagetype = $_FILES['articleimage']['type'];
	$imagesize = $_FILES['articleimage']['size'];
	$date = date('YMd-his');
	$newImageName = $date . '-' . $imagename;
	$caption = strip_tags(pg_escape_string($dbc, trim($_POST['imagecaption'])));
	if (!empty($title) && !empty($articleBody)) //both title and body are not empty
	{
		// OK!
		if (!empty($imagename) && move_uploaded_file($_FILES['articleimage']['tmp_name'], 'img/articles/' . $newImageName))
		{
			// If there is a photo, move it to the articles folder
			//move_uploaded_file($_FILES['articleimage']['tmp_name'], 'img/articles/' . $newImageName);
			pg_query($dbc, "INSERT INTO article (author, article_title, article_type, article_body, articlephoto, photo_caption) VALUES ('$author', '$title', '$articleTypeID', '$articleBody', '$newImageName', '$caption')");
		}
		else
		{
			pg_query($dbc, "INSERT INTO article (author, article_title, article_type, article_body) VALUES ('$author', '$title', '$articleTypeID', '$articleBody')");
		}
		pg_close($dbc);
		@unlink($_FILES['articleimage']['tmp_name']);
		$status = "AUSTRALIA";
	}
	if (empty($title) && empty($articleBody)) //both title and body are empty
	{
		// ERROR!
		$errors[] = "EMPTY_TITLE";
		$errors[] = "EMPTY_BODY";
		$status = "PHILIPPINES";
	}
	if (!empty($title) && empty($articleBody)) // only body is empty
	{
		// ERROR!
		$errors[] = "EMPTY_BODY";
		$status = "AFGHANISTAN";
	}
	if (empty($title) && !empty($articleBody)) // only title is empty
	{
		// ERROR!
		$errors[] = "EMPTY_TITLE";
		$status = "NORTH KOREA";
	}
	$jsonArticleResponse = array();
	$jsonArticleResponse['errors'] = $errors;
	$jsonArticleResponse['country'] = $status;
	print json_encode($jsonArticleResponse);
?>