<?php 
//	include_once('DBConnection.php');
//	$dbcArticle = new Article(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
?>
<?php header('Content-Type: text/xml'); ?>
<?php echo '<?xml version="1.0" encoding="utf-8"?>'; ?>
<rss version="2.0">
  	<channel>
    	<title>Silahis</title>
    	<link>http://127.0.0.1/silahis-news-site/</link>
    	<description>Official Student Publication of Mindanao State University - Iligan Institute of Technology</description>
    	<language>en-au</language>

    	<?php
    		include_once('backend/Articles.php');
			require_once('backend/silahis_connectvars.php');
			$dbc = new Article(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    		$articles = $dbc->get_results("SELECT article_id FROM article WHERE status = 'Published'");
    		for ($i = 0; $i < count($articles); $i++)
    		{
    			$article_id = $articles[$i]['article_id'];
    			echo '<item>';
    			echo '  <title>' . $dbc->getTitle($article_id) . '</title>';
   				echo '  <link>http://127.0.0.1/silahis-news-site/article.php?article=' . $article_id . '</link>';
    			echo '  <pubDate>' . date('D, d M Y H:i:s O', strtotime($dbc->getPublishedDate($article_id))) . '</pubDate>';
    			echo '  <description>' . $dbc->getTeaser($article_id) . '</description>';
    			echo '</item>';
    		}
    		
    	?>

	</channel>
</rss>