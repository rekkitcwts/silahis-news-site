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
	$latestEditorialArticleID = $dbc->getLatestEditorialArticle();
	$latestNewsArticles = $dbc->getLatestArticles("news", 5);
	$latestFeatureArticles = $dbc->getLatestArticles("feature", 4);
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8"> 
        <title><?php echo $dbc->getTitle($article_id); ?> - SILAHIS - MSU-IIT Student Publication</title>
        <meta name="generator" content="Bootply" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<!-- Uncomment if live site -->
    <!--    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet"> -->
		<link href="css/bootstrap.css" rel="stylesheet">
        
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
		<!--<link href="css/silahis.css" rel="stylesheet">-->
		<link href="css/article.css" rel="stylesheet" />
	</head>
	<body>
	<br />
	<br />
	<div class="container-fluid"> 
	<div class="row">
	<div class="container">
		<div class="col-md-12">
			<div class="col-sm-8">
				<h1 class="articleHead"><?php echo $dbc->getTitle($article_id); ?></h1>
				<p><?php echo 'By ' . $dbcStudent->getFirstName($dbc->getAuthor($article_id)) . ' ' . $dbcStudent->getLastName($dbc->getAuthor($article_id)); ?><p>
				<p>Published on <?php echo date('j F Y (h:i A)', strtotime($dbc->getPublishedDate($article_id))); ?></p>
				<?php echo '<img src="' . $dbc->getMainPhotoURL($article_id) . '" alt="' . $dbc->getTeaser($article_id) . '" class="img-responsive main-image" />';
				?>
				<small><?php echo $dbc->getTeaser($article_id); ?></small>
				<br /><br />
				<?php
					echo $dbc->getArticleBody($article_id);
				?>
			</div>
			<div class="col-md-4">
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
			<div id="features" class="feature-generic">
			<h2 class="features-header">Features</h2>
				<ul class="feature-main">			
					<?php
						if (count($latestFeatureArticles) == 0)
						{
							echo '<li class="medium-image">';
							echo '</li>';
							echo '<-- -->';
						}
						else
						{
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
						}
					?>
				</ul>
			</div>
	<div class="editorialbox">
	<div id="container-editorial-promotion" class="container-editorial-promotion">
		<h2 class="editorials-header">Editorial</h2>
		<ul class="editorial-breakout">
		<li class="first-child large-image">
			<h3 class="editorial-header">
			<a class="story" href="article.php?article=<?php echo $latestEditorialArticleID; ?>">
				<img alt="<?php echo $dbc->getTeaser($latestEditorialArticleID); ?>" src="<?php echo $dbc->getMainPhotoURL($latestEditorialArticleID); ?>">
				<?php echo $dbc->getTitle($latestEditorialArticleID); ?>
			</a>
			</h3>
			<p><?php echo $dbc->getTeaser($latestEditorialArticleID); ?></p>
		</li>
		</ul>
		</div>
	</div>
			</div> <!-- /.col-md-4 -->
		</div>
	</div>
</div>
</div>
	<script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.js"></script>
	</body>
</html>