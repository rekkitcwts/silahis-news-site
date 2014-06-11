<?php
if (!is_numeric($_GET['type']))
{
	echo 'Illegal operation.';
	exit();
}

$type = '';
switch ($_GET['type']) 
{
	case 1:
    	$type = 'News';
    	break;
  	case 2:
    	$type = 'Feature';
    	break;
  	case 3:
    	$type = 'Opinion';
    	break;
    case 4:
    	$type = 'Literary';
    	break;
    case 5:
    	$type = 'Editorial';
    	break;
  	default:
    	exit();
}

$stringLowercaseType = strtolower($type);

$pageTitle = $type;
require_once('template/silahis_header.php');
require_once('backend/Articles.php');
require_once('backend/silahis_connectvars.php');
$dbcArticles = new Article(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	require_once('template/silahis_topnavbar.php');
	require_once('template/silahis_sectionsidebar.php');
	$sectionSpotlightArray = $dbcArticles->getMostViewedArticles($stringLowercaseType, 3);
	$sectionLatestArticlesArray = $dbcArticles->getLatestArticles($stringLowercaseType, 8);
?>
	<h1><?php echo $type; ?></h1>
	<?php
		if (count($sectionSpotlightArray) == 0)
		{
			echo '<p>No articles in this section yet. Check back soon for more articles.</p>';
		}
		else
		{
			for ($s=0; $s < count($sectionSpotlightArray); $s++) 
			{ 
				if ($s == 0)
				{
					echo '<div class="col-md-12 section-spotlight-first">';
					echo '<h2><a href="article.php?article=' . $sectionSpotlightArray[0]['article_id'] . '">' . $dbcArticles->getTitle($sectionSpotlightArray[0]['article_id']) . '</a></h2>';
					echo '<div class="col-sm-6">';
					echo '<a href="article.php?article=' . $sectionSpotlightArray[0]['article_id'] . '"><img class="img-responsive section-img" src="'.$dbcArticles->getMainPhotoURL($sectionSpotlightArray[0]['article_id']).'" alt="'.$dbcArticles->getTeaser($sectionSpotlightArray[0]['article_id']).'" /></a>';
					echo '</div>'; //closes col-sm-6
					echo '<div class="col-sm-6">';
					echo '<p>' . $dbcArticles->getTeaser($sectionSpotlightArray[0]['article_id']) . '</p>';
					echo '</div>'; // closes col-sm-6
				}
				else
				{
					echo '<div class="col-md-12 section-spotlight-nonfirst">';
					echo '<div class="col-sm-6">';
					echo '<a href="article.php?article=' . $sectionSpotlightArray[$s]['article_id'] . '"><img class="img-responsive section-img" src="'.$dbcArticles->getMainPhotoURL($sectionSpotlightArray[$s]['article_id']).'" alt="'.$dbcArticles->getTeaser($sectionSpotlightArray[$s]['article_id']).'" /></a>';
					echo '</div>';
					echo '<div class="col-sm-6">';
					echo '<h4><a href="article.php?article=' . $sectionSpotlightArray[$s]['article_id'] . '">' . $dbcArticles->getTitle($sectionSpotlightArray[$s]['article_id']) . '</a></h4>';
					echo '<p>' . $dbcArticles->getTeaser($sectionSpotlightArray[$s]['article_id']) . '</p>';
					echo '</div>';
				}

				echo '</div>'; // closes col-md-12 divs
			}
		}
	?>
	<!-- ...ends here. -->
	<h1>Latest</h1>
	<div class="col-md-12">
		<div class="col-sm-6">
<!--			<h3>Moriya Shrine extends to Wollongong</h3>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
			<h3>Hakurei Shrine extends to Sydney</h3>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p> -->
			<?php
				if (count($sectionLatestArticlesArray) == 0)
				{
					echo '<h3>No articles in this section yet.</h3>';
					echo '<p>Check back soon for more articles.</p>';
				}
				else
				{
					for ($latestLeft=0; $latestLeft < 2 ; $latestLeft++) 
					{ 
						echo '<h3><a href="article.php?article=' . $sectionLatestArticlesArray[$latestLeft]['article_id'] . '">'.$dbcArticles->getTitle($sectionLatestArticlesArray[$latestLeft]['article_id']).'</a></h3>';
						echo '<p>' . $dbcArticles->getTeaser($sectionLatestArticlesArray[$latestLeft]['article_id']) . '</p>';
					}
				}
			?>
		</div>
		<div class="col-sm-6">
			<ul class="list-unstyled">
				<?php
				if (count($sectionLatestArticlesArray) > 2) 
				{
					for ($latestRight=3; $latestRight < count($sectionLatestArticlesArray) ; $latestRight++) 
					{ 
						echo '<li><a href="article.php?article=' . $sectionLatestArticlesArray[$latestRight]['article_id'] . '">'.$dbcArticles->getTitle($sectionLatestArticlesArray[$latestRight]['article_id']).'</a><br /><br /></li>';
					}
				}
				?>
			</ul>
		</div>
	</div>
<?php
		require_once('template/silahis_contentseparator.php');
?>
	<div id="week-recent" class="top-stories-range-module" style="padding-left: 4px; padding-right: 4px;">
		<h2 class="top-stories-range-module-header">Most Recent</h2>
		<h4>This week's recent articles</h4>
		<ul class="list-unstyled">
		<?php
			$recentPerDayArticles = $dbcArticles->prevDaysRecentArticles();
			for ($i=0; $i < count($recentPerDayArticles); $i++)
			{
				echo '<li>';
				echo '<a href="article.php?article=' . $recentPerDayArticles[$i]['article_id'] . '">';
				echo $dbcArticles->getTitle($recentPerDayArticles[$i]['article_id']) . ' (' . date("l, j F Y", strtotime($recentPerDayArticles[$i]['d'])) . ')';
				echo '</a>';
				echo '</li>';
			}
		?>
	</ul>
	</div>
<?php
require_once('template/silahis_footer.php');
?>