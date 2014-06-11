<?php
require_once('backend/Articles.php');
	require_once('backend/Student.php');
	require_once('backend/silahis_connectvars.php');
	$dbc = new Article(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	$dbcStudent = new Student(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	if ((!is_numeric($_GET['article'])) || ($dbc->getStatus($_GET['article']) == 'Pending') || ($dbc->isDeleted($_GET['article']) == true))
	{
		echo 'Illegal operation';
		exit();
	}


	$article_id = $_GET['article'];
	$dbc->incrementViews($article_id);
$pageTitle = $dbc->getTitle($article_id);
require_once('template/silahis_header.php');
	$latestEditorialArticle = $dbc->getLatestArticles("editorial", 1, $article_id);
	$latestNewsArticles = $dbc->getLatestArticles("news", 5, $article_id);
	$latestFeatureArticles = $dbc->getLatestArticles("feature", 4, $article_id);
	require_once('template/silahis_topnavbar.php');
	require_once('template/silahis_sectionsidebar.php');
?>
	<link href="css/article.css" rel="stylesheet" />

				<h1 class="articleHead"><?php echo $dbc->getTitle($article_id); ?></h1>
				<p><?php echo 'By ' . $dbcStudent->getFirstName($dbc->getAuthor($article_id)) . ' ' . $dbcStudent->getLastName($dbc->getAuthor($article_id)); ?><p>
				<p>Published on <?php echo date('j F Y (h:i A)', strtotime($dbc->getPublishedDate($article_id))); ?></p>
				<?php echo '<img src="' . $dbc->getMainPhotoURL($article_id) . '" alt="' . $dbc->getTeaser($article_id) . '" class="img-responsive main-image" />';
				?>
				<small><?php echo $dbc->getTeaser($article_id); ?></small>
				<br /><br />
				<?php
					echo $dbc->getArticleBody($article_id);
					require_once('template/silahis_contentseparator.php');
				?>
				<div id="range-top-stories" class="top-stories-range-module">
				<div class="row">
					<div class="col-md-12">
				<h2 style="margin-top: 5px;" class="top-stories-range-module-header">Spotlight</h2>		
				<!-- Non specific version -->
					<ul class="nostyle">
						<?php
						for ($i = 0; $i < count($latestNewsArticles); $i++)
						{
							if ($i == 0)
							{
								echo '<li class="first-child medium-image">';
								echo '<a class="story" href="article.php?article='. $latestNewsArticles[0]['article_id'] .'">';
								echo '<img src="'.$dbc->getMainPhotoURL($latestNewsArticles[0]['article_id']).'" alt="'.$dbc->getTeaser($latestNewsArticles[0]['article_id']).'" />';
								echo $dbc->getTitle($latestNewsArticles[0]['article_id']);
								echo '</a>';
								echo '</li>';
							}
							if ($i > 0)
							{
								echo '<li>';
								echo '<a class="story" href="article.php?article='.$latestNewsArticles[$i]['article_id'].'">';
								echo $dbc->getTitle($latestNewsArticles[$i]['article_id']);
								echo '</a>';
								echo '</li>';
							}
						}
						?>
					</ul>
					</div>
				</div>
			</div>		
					<?php
						if (count($latestFeatureArticles) > 0)
						{
							echo '<div id="features" class="feature-generic">';
								echo '<h2 class="features-header">Features</h2>';
								echo '<ul class="feature-main">';	
							for ($j = 0; $j < count($latestFeatureArticles); $j++)
							{
								
								echo '<li class="medium-image">';
									echo '<h3 class="feature-header">';
										echo '<a class="story" href="article.php?article='.$latestFeatureArticles[$j]['article_id'].'">';
											echo '<img src="'.$dbc->getMainPhotoURL($latestFeatureArticles[$j]['article_id']).'" alt="'.$dbc->getTeaser($latestFeatureArticles[$j]['article_id']).'">';
											echo $dbc->getTitle($latestFeatureArticles[$j]['article_id']);
										echo '</a>';
									echo '</h3>';
									echo '<p class="teaser">';
										echo $dbc->getTeaser($latestFeatureArticles[$j]['article_id']);
									echo '</p>';
								echo '</li>';
								
							}
							echo '</ul>';
							echo '</div>';
						}
					?>
	<?php
	if (count($latestEditorialArticle) > 0) 
	{
		echo '<div class="editorialbox">';
		echo '<div id="container-editorial-promotion" class="container-editorial-promotion">';
		echo '<h2 class="editorials-header">Editorial</h2>';
		echo '<ul class="editorial-breakout">';
		echo '<li class="first-child large-image">';
			echo '<h3 class="editorial-header">';
			echo '<a class="story" href="article.php?article='.$latestEditorialArticle[0]['article_id'].'">';
			echo '<img alt="' . $dbc->getTeaser($latestEditorialArticle[0]['article_id']).'" src="'. $dbc->getMainPhotoURL($latestEditorialArticle[0]['article_id']) . '">';
			echo $dbc->getTitle($latestEditorialArticle[0]['article_id']);
			echo '</a>';
			echo '</h3>';
			echo '<p>'.$dbc->getTeaser($latestEditorialArticle[0]['article_id']).'</p>';
		echo '</li>';
		echo '</ul>';
		echo '</div>';
	echo '</div>';
	}
	?>
<?php
require_once('template/silahis_footer.php');
?>