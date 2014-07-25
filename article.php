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
	$typeID = $dbc->getArticleType($_GET['article']);
	switch ($typeID) {
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
    	case 5: // sports news
    	$type = 'News';
    	break;
    	case 6:
    	$type = 'Editorial';
    	break;
  		default:
    	$type = '';
	}
	$dbc->incrementViews($article_id);
$pageTitle = $dbc->getTitle($article_id);
require_once('template/silahis_header.php');
	$latestEditorialArticle = $dbc->getLatestArticles("editorial", 1, $article_id);
	$latestNewsArticles = $dbc->getLatestArticles("news", 5, $article_id);
	$latestFeatureArticles = $dbc->getLatestArticles("feature", 4, $article_id);
	require_once('template/silahis_topnavbar.php');
	require_once('template/silahis_sectionsidebar.php');
?>
				<h1><?php echo $dbc->getTitle($article_id); ?></h1>
				<p><?php echo 'By ' . $dbcStudent->getFirstName($dbc->getAuthor($article_id)) . ' ' . $dbcStudent->getLastName($dbc->getAuthor($article_id)); ?><p>
				<p>Published on <?php echo date('j F Y (h:i A)', strtotime($dbc->getPublishedDate($article_id))); ?></p>
				<div class="article-content-photo">
				<?php echo '<img src="' . $dbc->getMainPhotoURL($article_id) . '" alt="' . $dbc->getTeaser($article_id) . '" class="img-responsive" />';
				?>
				</div>
				<small><?php echo $dbc->getTeaser($article_id); ?></small>
				<br /><br />
				<div id="articleBodyContent">
				<?php
					echo $dbc->getArticleBody($article_id);
				?>
				</div>
				    <div id="disqus_thread"></div>
    <script type="text/javascript">
        /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
        var disqus_shortname = 'kureidodisqustest'; // required: replace example with your forum shortname

        /* * * DON'T EDIT BELOW THIS LINE * * */
        (function() {
            var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
            dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
        })();
    </script>
    <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
<!--					
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
-->
</div>

      				<!-- Spotlight For Articles -->
      				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
      					<div class="row">
      						<div class="col-xs-12 col-lg-12 col-md-12">
                                <div class="spotlight-content-sidebar">
      							<h1>Spotlight</h1>
                                </div>
						<?php
						if (count($latestNewsArticles) > 0)
						{
							for ($i = 0; $i < count($latestNewsArticles); $i++)
							{
								echo '<div class="row">';
								if ($i == 0)
								{
									echo '<div class="col-xs-12 col-sm-6">';
                                    echo '<img class="img-responsive" src="'.$dbc->getMainPhotoURL($latestNewsArticles[0]['article_id']).'" alt="'.$dbc->getTeaser($latestNewsArticles[0]['article_id']).'" />';
                                    echo '</div>';
                                    echo '<div class="col-xs-12 col-sm-6">';
                                    echo '<a href="article.php?article='. $latestNewsArticles[0]['article_id'] .'"><p>'.$dbc->getTitle($latestNewsArticles[0]['article_id']).'</p></a>';
                                    echo '</div>';

								}
								if ($i > 0)
								{
									echo '<div class="col-xs-12">';
                                    echo '<a href="article.php?article='. $latestNewsArticles[$i]['article_id'] .'"><p>'.$dbc->getTitle($latestNewsArticles[$i]['article_id']).'</p></a>';
                                    echo '</div>';
								}
								echo '</div>';
							}
						}

						if (count($latestFeatureArticles) > 0)
						{
							echo '<div class="row">';
                            echo '<div class="col-xs-12 col-lg-12 col-md-12">';
                            echo '<div class="spotlight-content-sidebar">';
                            echo '<h1>Feature</h1>';
                            echo '</div>';
                            for ($j = 0; $j < count($latestFeatureArticles); $j++)
							{
								echo '<div class="row">';
                                echo '<div class="col-xs-12 col-sm-6">';
                                echo '<img class="img-responsive" src="'.$dbc->getMainPhotoURL($latestFeatureArticles[$j]['article_id']).'" alt="'.$dbc->getTeaser($latestFeatureArticles[$j]['article_id']).'" />';
                                echo '</div>';
                                echo '<div class="col-xs-12 col-sm-6">';
                                echo '<a href="article.php?article='.$latestFeatureArticles[$j]['article_id'].'"><p>'.$dbc->getTitle($latestFeatureArticles[$j]['article_id']).'</p></a>';
                                echo '</div></div>';
							}
						}

						if (count($latestEditorialArticle) > 0) 
						{
							echo '<div class="row">';
							echo '<div class="col-xs-12 col-lg-12 col-md-12">';
      						echo '<div id="popular-opinion">';
                            echo '<h1>Editorial</h1>';
                            echo '<div class="row">';
                            echo '<div class="col-xs-12">';
                            echo '<div id="popular-opinion-content">';
                            echo '<a href="article.php?article='.$latestEditorialArticle[0]['article_id'].'">';
                            echo '<img class="img-responsive" src="'. $dbc->getMainPhotoURL($latestEditorialArticle[0]['article_id']) . '" alt="' . $dbc->getTeaser($latestEditorialArticle[0]['article_id']).'" />';
                            echo '<p>'.$dbc->getTitle($latestEditorialArticle[0]['article_id']).'</p></a>';
                            echo '</div></div></div></div></div>';
      						echo '</div>';
						}
						?>  
						</div>
						</div>
						</div>
						</div>        
<?php
require_once('template/silahis_footer.php');
?>