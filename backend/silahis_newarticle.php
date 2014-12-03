<?php
require_once('silahis_backendsecurity.php');
$data = array();
$errors = array();
$status = "";
require_once('silahis_connectvars.php');
include_once('Articles.php');
require_once('../template/silahis_sessionstarter.php');
$author = $_SESSION['staff_id'];

if (!empty($_SESSION['last_img_uploaded']))
$main_image = $_SESSION['last_img_uploaded'];
/*$articletitle_unescaped = $_POST['title'];
$articletitle = strip_tags(str_replace('\'', '\'\'', trim($_POST['title'])));
$articleTypeID = $_POST['articleselection'];
$articleBody = str_replace('<img ', '<img class="img-responsive" ', trim($_POST['articlebody']));
$imagename = strip_tags(str_replace('\'', '\'\'', trim($_POST['articleimage'])));
$caption = strip_tags(str_replace('\'', '\'\'', trim($_POST['imagecaption']))); */

$data = $_POST;
$data['title'] = strip_tags(str_replace('\'', '\'\'', trim($_POST['title'])));
$data['articlebody'] = str_replace("\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t", "", $_POST['articlebody']);
if ($data['title'] == "") 
{
	$errors[] = 'TITLE_MISSING';
}
if ($data['articlebody'] == "") 
{
	$errors[] = 'BODY_MISSING';
}

echo json_encode($data);
?>