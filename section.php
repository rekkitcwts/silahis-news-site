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
					echo '<h2><a href="article.php?article=' . $sectionSpotlightArray[0]['article_id'] . '">' . $dbcArticles->getTitle($sectionSpotlightArray[0]['article_id']) . '</a></h2>';
                    echo '<div class="row">';
                    echo '<div class="col-xs-12 col-sm-6">';
                    echo '<img class="img-responsive" src="'.$dbcArticles->getMainPhotoURL($sectionSpotlightArray[0]['article_id']).'" alt="'.$dbcArticles->getTeaser($sectionSpotlightArray[0]['article_id']).'" />';
                    echo '</div>';
                    echo '<div class="col-xs-12 col-sm-6">';
                    echo '<p>'.$dbcArticles->getTeaser($sectionSpotlightArray[0]['article_id']).'</p>';
                    echo '</div>';
                    echo '</div>'; 
				}
				else
				{
					echo '<div class="row">';
                    echo '<div class="col-xs-12 col-sm-6">';
                    echo '<img class="img-responsive" src="'.$dbcArticles->getMainPhotoURL($sectionSpotlightArray[$s]['article_id']).'" alt="'.$dbcArticles->getTeaser($sectionSpotlightArray[$s]['article_id']).'" />';
                    echo '</div>';
                    echo '<div class="col-xs-12 col-sm-6">';
                    echo '<h5><strong><a href="article.php?article=' . $sectionSpotlightArray[$s]['article_id'] . '">' . $dbcArticles->getTitle($sectionSpotlightArray[$s]['article_id']) . '</a></strong></h5>';
                    echo '<p>' . $dbcArticles->getTeaser($sectionSpotlightArray[$s]['article_id']) . '</p>';
                    echo '</div>';
                    echo '</div>';
				}

				echo '<div class="row">';
                echo '<div class="col-xs-12">';
                echo '&nbsp;';
                echo '</div>';
                echo '</div>';
			}
		}
	?>
	<!-- ...ends here. -->
	<h1 class="sectionHeader">Latest</h1>
<!--	<div class="col-md-12">
		<div class="col-sm-6 latest-section-articles">
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
		<div class="col-sm-6 latest-section-exclusive">
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
	</div> -->
	<div class="row">
        <div class="col-xs-12 col-sm-6">
        	<?php
				if (count($sectionLatestArticlesArray) == 0)
				{
					echo '<h3>No articles in this section yet.</h3>';
					echo '<p>Check back soon for more articles.</p>';
				}
				else
				{
					if (count($sectionLatestArticlesArray) == 1) 
					{
						echo '<h3><a href="article.php?article=' . $sectionLatestArticlesArray[0]['article_id'] . '">'.$dbcArticles->getTitle($sectionLatestArticlesArray[0]['article_id']).'</a></h3>';
						echo '<p class="hidden-xs">' . $dbcArticles->getTeaser($sectionLatestArticlesArray[0]['article_id']) . '</p>';
					}
					else
					{
						for ($latestLeft=0; $latestLeft < 2 ; $latestLeft++) 
						{
							echo '<h3><a href="article.php?article=' . $sectionLatestArticlesArray[$latestLeft]['article_id'] . '">'.$dbcArticles->getTitle($sectionLatestArticlesArray[$latestLeft]['article_id']).'</a></h3>';
							echo '<p class="hidden-xs">' . $dbcArticles->getTeaser($sectionLatestArticlesArray[$latestLeft]['article_id']) . '</p>';
						}
					}
				}
			?>
        </div>
        <div class="col-xs-12 col-sm-6">
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
</div>
<?php
	//	require_once('template/silahis_contentseparator.php');
?>
<!--	<div id="week-recent" class="top-stories-range-module" style="padding-left: 4px; padding-right: 4px;">
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
	</div> -->
<!-- Right sidebar, adjusting this is tricky. -->
<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
    <div class="row">
    <h1>Past Days' Popular</h1>
    <div id="events-calendar">
    	<!-- EVENT ITEM -->
		<?php
			$recentPerDayArticles = $dbcArticles->prevDaysRecentArticles();
			for ($i=0; $i < count($recentPerDayArticles); $i++)
			{
				/*echo '<li>';
				echo '<a href="article.php?article=' . $recentPerDayArticles[$i]['article_id'] . '">';
				echo $dbcArticles->getTitle($recentPerDayArticles[$i]['article_id']) . ' (' . date("l, j F Y", strtotime($recentPerDayArticles[$i]['d'])) . ')';
				echo '</a>';
				echo '</li>'; */
				echo '<div class="row event-item">';
        		echo '<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">';
            	echo '<a href="article.php?article=' . $recentPerDayArticles[$i]['article_id'] . '">';
                echo '<span class="day">'.$dbcArticles->getArticleTypeName($recentPerDayArticles[$i]['article_id']).'</span>';
                echo '<span class="date">' . date("F j", strtotime($recentPerDayArticles[$i]['d'])) . '</span>';
                echo '</a>';
            	echo '</div>';
            	echo '<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">';
                echo '<h5><a href="article.php?article=' . $recentPerDayArticles[$i]['article_id'] . '">'.$dbcArticles->getTitle($recentPerDayArticles[$i]['article_id']).'</a></h5>';
            	echo '</div>';
        		echo '</div>';
			}
		?>

            </div>
        </div>
<?php
require_once('template/silahis_footer.php');
?>