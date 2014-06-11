<?php
$search_query = strip_tags(str_replace('\'', '\'\'',trim($_GET['search_string'])));
$pageTitle = 'Search results for \'' . $search_query . '\'';
require_once('template/silahis_header.php');
require_once('backend/silahis_connectvars.php');
	require_once('template/silahis_topnavbar.php');
	require_once('template/silahis_sectionsidebar.php');
?>
	<h1>Results for '<?php echo $search_query; ?>'</h1>
<?php
		require_once('template/silahis_contentseparator.php');
?>
									<p>Right Sidebar</p>
<?php
require_once('template/silahis_footer.php');
?>