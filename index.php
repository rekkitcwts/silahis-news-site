<?php
require_once('backend/Articles.php');
require_once('backend/silahis_connectvars.php');
$pageTitle = 'Home';
$type = '';
require_once('template/silahis_header.php');
require_once('template/silahis_topnavbar.php');
require_once('template/silahis_sectionsidebar.php');
$dbcArticles = new Article(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$latestNews = $dbcArticles->getLatestArticles("news", 7);
$mostViewedNews = $dbcArticles->getMostViewedArticles("news", 4);
$latestFeatures = $dbcArticles->getLatestArticles("feature",2);
$latestOpinion = $dbcArticles->getLatestArticles("opinion",1);
$latestEditorial = $dbcArticles->getLatestArticles("editorial",1);
$latestLiterary = $dbcArticles->getLatestArticles("literary",1);
?>
<!-- ORIGINAL END -->
<h1 class="headertitle">Spotlight</h1>
<!-- CAROUSEL -->
<div class="row">
	<div id="carousel-container" class="col-lg-12 col-md-12 col-sm-12">
		<!-- CAROUSEL HOMEPAGE -->
		<div id="carousel-homepage" class="carousel slide" data-ride="carousel">
			<!-- Indicators -->
			<ol class="carousel-indicators">
				<?php
				for ($mostViewedNewsIndicators=0; $mostViewedNewsIndicators < count($mostViewedNews); $mostViewedNewsIndicators++) 
				{ 
					echo '<li data-target="#carousel-homepage" ';
					echo 'data-slide-to="'.$mostViewedNewsIndicators.'" ';
					if ($mostViewedNewsIndicators == 0)
					{
						echo 'class="active"></li>';
					}
					else
					{
						echo '></li>';
					}
				}
				?>
			</ol>

			<!-- Wrapper for slides -->
			<div class="carousel-inner">
				<?php
				for ($mostViewedNewsIndex=0; $mostViewedNewsIndex < count($mostViewedNews) ; $mostViewedNewsIndex++) 
				{ 
					if ($mostViewedNewsIndex == 0)
					{
						echo '<div class="item active">';
					}
					else
					{
						echo '<div class="item">';
					}
					echo '<a href="article.php?article='.$mostViewedNews[$mostViewedNewsIndex]['article_id'].'"><img class="img-responsive" src="'.$dbcArticles->getMainPhotoURL($mostViewedNews[$mostViewedNewsIndex]['article_id']).'" alt="'.$dbcArticles->getTeaser($mostViewedNews[$mostViewedNewsIndex]['article_id']).'"></a>';
					echo '<div class="carousel-caption caption-left">';
					echo '<a href="article.php?article='.$mostViewedNews[$mostViewedNewsIndex]['article_id'].'">';
					echo '<h2>'.$dbcArticles->getTitle($mostViewedNews[$mostViewedNewsIndex]['article_id']).'</h2>';
					echo '<p class="hidden-xs">'.$dbcArticles->getTeaser($mostViewedNews[$mostViewedNewsIndex]['article_id']).'</p></a>';
					echo '</div>';
					echo '</div>';
				}
				?>
			</div>



			<!-- Controls -->
			<a class="left carousel-control" href="#carousel-homepage" data-slide="prev">
				<span class="glyphicon glyphicon-chevron-left"></span>
			</a>
			<a class="right carousel-control" href="#carousel-homepage" data-slide="next">
				<span class="glyphicon glyphicon-chevron-right"></span>
			</a>
		</div>
		<!-- end of CAROUSEL HOMEPAGE -->
	</div>
</div>
<!-- end of CAROUSEL -->
<div class="row">
	<div class="col-xs-12">
		<h1>News</h1>
	</div>
	<div class="col-xs-12 col-sm-6">
		<div class="homepage-article-title">
			<a href="article.php?article=<?php echo $latestNews[0]['article_id']; ?>"><h4><?php echo $dbcArticles->getTitle($latestNews[0]['article_id']); ?></h4></a>
		</div>
		
		<div class="row">
			<div class="col-xs-12 col-sm-6">
				<img class="img-responsive homepage-latest-article-img" src="<?php echo $dbcArticles->getMainPhotoURL($latestNews[0]['article_id']); ?>" alt="<?php echo $dbcArticles->getTeaser($latestNews[0]['article_id']); ?>" />
			</div>
			<div class="col-xs-12 col-sm-6">
				<p><?php echo $dbcArticles->getTeaser($latestNews[0]['article_id']); ?></p>
			</div>
		</div>
	</div>
	<div class="col-xs-12 col-sm-6">
		<div class="homepage-article-title">
			<a href="article.php?article=<?php echo $latestNews[1]['article_id']; ?>"><h4><?php echo $dbcArticles->getTitle($latestNews[1]['article_id']); ?></h4></a>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-6">
				<img class="img-responsive homepage-latest-article-img" src="<?php echo $dbcArticles->getMainPhotoURL($latestNews[1]['article_id']); ?>" alt="<?php echo $dbcArticles->getTeaser($latestNews[1]['article_id']); ?>" />
			</div>
			<div class="col-xs-12 col-sm-6">
				<p><?php echo $dbcArticles->getTeaser($latestNews[1]['article_id']); ?></p>
			</div>
		</div>
	</div>
</div>
<!-- Feature -->
<div class="row">
	<div class="col-xs-12">
		<h1>Feature</h1>
	</div>
	<div class="col-xs-12 col-sm-6">
		<div class="homepage-article-title">
		<a href="<?php echo 'article.php?article=' . $latestFeatures[0]['article_id']; ?>"><h4><?php echo $dbcArticles->getTitle($latestFeatures[0]['article_id']); ?></h4></a>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-6">
				<img class="img-responsive homepage-latest-article-img" src="<?php echo $dbcArticles->getMainPhotoURL($latestFeatures[0]['article_id']); ?>" alt="<?php echo $dbcArticles->getTeaser($latestFeatures[0]['article_id']); ?>" />
			</div>
			<div class="col-xs-12 col-sm-6">
				<p><?php echo $dbcArticles->getTeaser($latestFeatures[0]['article_id']); ?></p>
			</div>
		</div>
	</div>
<?php
	if (isset($latestFeatures[1]))
	{
?>
	<div class="col-xs-12 col-sm-6">
		<div class="homepage-article-title">
		<a href="<?php echo 'article.php?article=' . $latestFeatures[1]['article_id']; ?>"><h4><?php echo $dbcArticles->getTitle($latestFeatures[1]['article_id']); ?></h4></a>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-6">
				<img class="img-responsive homepage-latest-article-img" src="<?php echo $dbcArticles->getMainPhotoURL($latestFeatures[1]['article_id']); ?>" alt="<?php echo $dbcArticles->getTeaser($latestFeatures[1]['article_id']); ?>" />
			</div>
			<div class="col-xs-12 col-sm-6">
				<p><?php echo $dbcArticles->getTeaser($latestFeatures[1]['article_id']); ?></p>
			</div>
		</div>
	</div>
<?php
	}
?>
</div>
</div>
<!-- End content -->
<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
	<div class="row">
		<?php
		if (count($latestOpinion) > 0)
		{
			echo '<div class="col-xs-12 col-lg-12 col-md-12 col-sm-4">';
			echo '<div id="popular-opinion">';
			echo '<h1>Opinion</h1>';
			echo '<div class="row">';
			echo '<div class="col-xs-12">';
			echo '<div id="popular-opinion-content">';
			echo '<a href="article.php?article='.$latestOpinion[0]['article_id'].'">';
			echo '<img class="img-responsive" src="'.$dbcArticles->getMainPhotoURL($latestOpinion[0]['article_id']).'" alt="'.$dbcArticles->getTeaser($latestOpinion[0]['article_id']).'" />';
			echo '<p>'.$dbcArticles->getTitle($latestOpinion[0]['article_id']).'</p></a>';
			echo '</div></div></div></div></div>';
		}
		?>
		<?php
		if (count($latestEditorial) > 0)
		{
			echo '<div class="col-xs-12 col-lg-12 col-md-12 col-sm-4">';
			echo '<div id="popular-opinion">';
			echo '<h1>Editorial</h1>';
			echo '<div class="row">';
			echo '<div class="col-xs-12">';
			echo '<div id="popular-opinion-content">';
			echo '<a href="article.php?article='.$latestEditorial[0]['article_id'].'">';
			echo '<img class="img-responsive" src="'.$dbcArticles->getMainPhotoURL($latestEditorial[0]['article_id']).'" alt="'.$dbcArticles->getTeaser($latestEditorial[0]['article_id']).'" />';
			echo '<p>'.$dbcArticles->getTitle($latestEditorial[0]['article_id']).'</p></a>';
			echo '</div></div></div></div></div>';
		}
		?>
		<!-- WAIT. -->
		<?php
		if (count($latestLiterary) > 0)
		{
			echo '<div class="col-xs-12 col-lg-12 col-md-12 col-sm-4">';
			echo '<div id="popular-opinion">';
			echo '<h1>Literary</h1>';
			echo '<div class="row">';
			echo '<div class="col-xs-12">';
			echo '<div id="popular-opinion-content">';
			echo '<a href="article.php?article='.$latestLiterary[0]['article_id'].'">';
			echo '<img class="img-responsive" src="'.$dbcArticles->getMainPhotoURL($latestLiterary[0]['article_id']).'" alt="'.$dbcArticles->getTeaser($latestLiterary[0]['article_id']).'" />';
			echo '<p>'.$dbcArticles->getTitle($latestLiterary[0]['article_id']).'</p></a>';
			echo '</div></div></div></div></div>';
		}
		?>
	</div>
		<?php
		require_once('template/silahis_footer.php');
		?>