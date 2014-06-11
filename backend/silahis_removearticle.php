<?php
	include_once('DBConnection.php');
	include_once('Articles.php');
	require_once('silahis_connectvars.php');
	$article = new Article(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	$articleID = $_POST['article_id'];
	if (is_numeric($articleID))
	{
		$article->removeArticle($articleID);
		echo 'ARTICLE_REMOVED';
	}
	else
	{
		echo 'INVALID_ARTICLE_ID';
	}
?>