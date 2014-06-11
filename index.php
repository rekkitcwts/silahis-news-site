<?php
	require_once('backend/Articles.php');
	require_once('backend/silahis_connectvars.php');
	$pageTitle = 'Home';
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
				<h2>Spotlight</h2>
				<div id="news-spotlight" class="carousel slide" data-ride="carousel">
				  <!-- Indicators -->
				  <ol class="carousel-indicators">
					<?php
					for ($mostViewedNewsIndicators=0; $mostViewedNewsIndicators < count($mostViewedNews); $mostViewedNewsIndicators++) 
					{ 
						echo '<li data-target="#news-spotlight" ';
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
							echo '<a href="article.php?article='.$mostViewedNews[$mostViewedNewsIndex]['article_id'].'"><img class="spotlight-image" src="'.$dbcArticles->getMainPhotoURL($mostViewedNews[$mostViewedNewsIndex]['article_id']).'" alt="'.$dbcArticles->getTeaser($mostViewedNews[$mostViewedNewsIndex]['article_id']).'"></a>';
					  		echo '<div class="carousel-caption">';
							echo '<h4><a class="carousel-headline" href="article.php?article='.$mostViewedNews[$mostViewedNewsIndex]['article_id'].'">'.$dbcArticles->getTitle($mostViewedNews[$mostViewedNewsIndex]['article_id']).'</a></h4>';
							echo '<h6 class="hidden-xs">'.$dbcArticles->getTeaser($mostViewedNews[$mostViewedNewsIndex]['article_id']).'</h6>';
					  		echo '</div>';
							echo '</div>';
						}
					?>
				  </div>

				  <!-- Controls -->
				  <a class="left carousel-control" href="#news-spotlight" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-left"></span>
				  </a>
				  <a class="right carousel-control" href="#news-spotlight" data-slide="next">
					<span class="glyphicon glyphicon-chevron-right"></span>
				  </a>
				</div>
				<h2>News</h2>
				<hr />
				<div class="row">
					<div class="col-md-6">
						<a href="article.php?article=<?php echo $latestNews[0]['article_id']; ?>">
						<img class="img-responsive two-col-news" src="<?php echo $dbcArticles->getMainPhotoURL($latestNews[0]['article_id']); ?>" alt="<?php echo $dbcArticles->getTeaser($latestNews[0]['article_id']); ?>" />
						<h3><?php echo $dbcArticles->getTitle($latestNews[0]['article_id']); ?></h3></a>
						<p><?php echo $dbcArticles->getTeaser($latestNews[0]['article_id']); ?></p>
					</div>
					<div class="col-md-6">
						<a href="article.php?article=<?php echo $latestNews[1]['article_id']; ?>">
						<img class="img-responsive two-col-news" src="<?php echo $dbcArticles->getMainPhotoURL($latestNews[1]['article_id']); ?>" alt="<?php echo $dbcArticles->getTeaser($latestNews[1]['article_id']); ?>" />
						<h3><?php echo $dbcArticles->getTitle($latestNews[1]['article_id']); ?></h3></a>
						<p><?php echo $dbcArticles->getTeaser($latestNews[1]['article_id']); ?></p>
					</div>
				<!--	<div class="col-md-3">
						<ul id="news" class="list-unstyled">
							<?php
								for ($n=2; $n < 5; $n++) 
								{ 
									echo '<li>';
									echo '<a href="article.php?article='.$latestNews[$n]['article_id'].'">';
									echo $dbcArticles->getTitle($latestNews[$n]['article_id']);
									echo '</a>';
									echo '<hr />';
									echo '</li>';
								}
							?>
						</ul>
					</div>  -->
					
				</div>
				<hr />
				<h2 class="homepage-header-indicator">Features</h2>
				<hr style="margin-top:0px;" />
				<div class="row">
					<?php
						for ($f=0; $f < count($latestFeatures); $f++) 
						{ 
							echo '<div class="col-md-6">';
							echo '<h3><a href="article.php?article='.$latestNews[$f]['article_id'].'">'.$dbcArticles->getTitle($latestFeatures[$f]['article_id']).'</a></h3>';
							echo '<div class="col-sm-6">';
							echo '<img class="img-responsive" src="'.$dbcArticles->getMainPhotoURL($latestFeatures[$f]['article_id']).'" alt="'.$dbcArticles->getTeaser($latestFeatures[$f]['article_id']).'" />';
							echo '</div>';
							echo '<div class="col-sm-6">';
							echo '<p>'.$dbcArticles->getTeaser($latestFeatures[$f]['article_id']).'</p>';
							echo '</div>';
							echo '</div>';
						}
					?>
				</div>
			<?php
				require_once('template/silahis_contentseparator.php');
			?>
				<?php
					if (count($latestOpinion) > 0)
					{
						echo '<h2>Opinion</h2>';
						echo '<a href="article.php?article='.$latestOpinion[0]['article_id'].'" class="thumb img-width-340">';
						echo '<img width="340px" height="227px" src="'.$dbcArticles->getMainPhotoURL($latestOpinion[0]['article_id']).'" alt="'.$dbcArticles->getTeaser($latestOpinion[0]['article_id']).'" />';
						echo '<span class="textOnImage">'.$dbcArticles->getTitle($latestOpinion[0]['article_id']).'</span>';
						echo '</a>';
					}
				?>
				<!--<a href="#" class="thumb img-width-340">
					<img width="340px" height="227px" src="img/Engineerava.jpg" alt="SCS Governor Harold Dumaog" />
					<span class="textOnImage">THE TOPLINE: Interview with incoming SCS Governor Harold Glenn Dumaog</span>
				</a>-->
				<br />
				<h2 class="homepage-header-indicator">Editorial</h2>
				<?php
					if (count($latestEditorial) == 0)
					{
						echo '<a href="#" class="thumb img-width-340">';
						echo '<img width="340px" height="227px" src="img/nophoto.png" alt="Showing 1 to NaN of NaN entries" />';
						echo '<span class="textOnImage">No article yet</span>';
						echo '</a>';
					}
					else
					{
						echo '<a href="article.php?article='.$latestEditorial[0]['article_id'].'" class="thumb img-width-340">';
						echo '<img width="340px" height="227px" src="'.$dbcArticles->getMainPhotoURL($latestEditorial[0]['article_id']).'" alt="'.$dbcArticles->getTeaser($latestEditorial[0]['article_id']).'" />';
						echo '<span class="textOnImage">'.$dbcArticles->getTitle($latestEditorial[0]['article_id']).'</span>';
						echo '</a>';
					}
				?>
				<br />
				<?php
					if (count($latestLiterary) > 0)
					{
						echo '<h2 class="homepage-header-indicator">Literary</h2>';
						echo '<a href="article.php?article='.$latestLiterary[0]['article_id'].'" class="thumb img-width-340">';
						echo '<img width="340px" height="227px" src="'.$dbcArticles->getMainPhotoURL($latestLiterary[0]['article_id']).'" alt="'.$dbcArticles->getTeaser($latestLiterary[0]['article_id']).'" />';
						echo '<span class="textOnImage">'.$dbcArticles->getTitle($latestLiterary[0]['article_id']).'</span>';
						echo '</a>';
					}
				?>
				<br />
<?php
	require_once('template/silahis_footer.php');
?>