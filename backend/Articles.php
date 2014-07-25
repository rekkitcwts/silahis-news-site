<?php
	include_once('DBConnection.php');

	class Article extends DBConnection
	{
		public function createArticle($articleArray)
		{
			$author_id = $articleArray['author'];
			$title = $articleArray['title'];
			$type = $articleArray['type'];
			$body = $articleArray['body'];
			$main_image_url = $articleArray['main_image'];
			$teaser = $articleArray['teaser'];

			$this->query("INSERT INTO article (author, article_title, article_type, article_body, articlephoto, photo_caption) VALUES ('$author_id', '$title', '$type', '$body', '$main_image_url', '$teaser')");
		}

		public function removeArticle($article_id)
		{
			$this->query("UPDATE article SET deleted = true WHERE article_id = $article_id");
		}

		public function publishArticle($article_id)
		{
			$this->query("UPDATE article SET status = 'Published', date_published = now()::timestamp without time zone WHERE article_id = $article_id");
		}

		public function getStatus($article_id)
		{
			return $this->get_var("SELECT status FROM article WHERE article_id = $article_id");
		}

		public function isDeleted($article_id)
		{
			if ($this->get_var("SELECT deleted FROM article WHERE article_id = $article_id") == 'f')
				return false;
			else
				return true;
		}

		public function getLatestEditorialArticle()
		{
			return $this->get_var("SELECT article.article_id FROM article INNER JOIN articletype ON (article.article_type = articletype.type_id) WHERE articletype.type_name = 'Editorial' AND article.status = 'Published' ORDER BY article.date_published DESC LIMIT 1");
		}

		public function getLatestArticles($type, $limit, $excludedArticleID = 0)
		{
			$comparison = "";
			$exclude = "";

			if ($excludedArticleID != 0)
			{
				$exclude = " AND article.article_id != $excludedArticleID";
			}
			
			if ($type == 'news')
			{
				$comparison = "LIKE '%News'";
			}
			else if ($type == 'feature')
			{
				$comparison = "= 'Feature'";
			}
			else if ($type == 'opinion')
			{
				$comparison = "= 'Opinion'";
			}
			else if ($type == 'editorial')
			{
				$comparison = "= 'Editorial'";
			}
			else if ($type == 'literary')
			{
				$comparison = "= 'Literary'";
			}
			else
			{
				return "Unknown type.";
			}
			$query = "SELECT article.article_id FROM article INNER JOIN articletype ON (article.article_type = articletype.type_id) WHERE articletype.type_name ";

			return $this->get_results($query . $comparison . " AND article.status = 'Published' AND deleted = false " . $exclude . " ORDER BY article.date_published DESC LIMIT $limit");
		}

		public function getMostViewedArticles($type, $limit)
		{
			$comparison = "";
			
			if ($type == 'news')
			{
				$comparison = "LIKE '%News'";
			}
			else if ($type == 'feature')
			{
				$comparison = "= 'Feature'";
			}
			else if ($type == 'opinion')
			{
				$comparison = "= 'Opinion'";
			}
			else if ($type == 'editorial')
			{
				$comparison = "= 'Editorial'";
			}
			else if ($type == 'literary')
			{
				$comparison = "= 'Literary'";
			}
			else
			{
				return "Unknown type.";
			}
			$query = "SELECT article.article_id FROM article INNER JOIN articletype ON (article.article_type = articletype.type_id) WHERE articletype.type_name ";

			return $this->get_results($query . $comparison . " AND article.status = 'Published' AND deleted = false ORDER BY article.article_views DESC, article.date_published DESC LIMIT $limit");
		}

		public function prevDaysRecentArticles()
		{
			return $this->get_results("SELECT d,article_id, date_published FROM (SELECT DISTINCT ON (d) date_trunc('day',date_published)::date as d ,article_id, date_published FROM article ORDER BY d desc, date_published desc) s ORDER BY d desc LIMIT 4;");
		}

		public function incrementViews($article_id)
		{
			$curviews = $this->get_var("SELECT article_views FROM article WHERE article_id = $article_id");
			$curviews++;
			$this->query("UPDATE article SET article_views = $curviews WHERE article_id = $article_id");
		}

		public function searchArticles($user_search)
		{
			$search_query = "SELECT article_id FROM article";

    		// Extract the search keywords into an array
    		$clean_search = str_replace(',', ' ', $user_search);
    		$search_words = explode(' ', $clean_search);
    		$final_search_words = array();
    		if (count($search_words) > 0) 
    		{
      			foreach ($search_words as $word) 
      			{
        			if (!empty($word)) 
        			{
          				$final_search_words[] = $word;
        			}
      			}
    		}

    		// Generate a WHERE clause using all of the search keywords
    		$where_list = array();
    		if (count($final_search_words) > 0) 
    		{
      			foreach($final_search_words as $word) 
      			{
        			$where_list[] = "LOWER(article_body) LIKE '%LOWER($word)%'";
      			}
    		}
    		$where_clause = implode(' OR ', $where_list);

    		// Add the keyword WHERE clause to the search query
    		if (!empty($where_clause)) 
    		{
      			$search_query .= " WHERE $where_clause AND deleted = false ORDER BY date_published DESC";
    		}
    		else
    		{
    			$search_query .= " WHERE deleted = false ORDER BY date_published DESC";	
    		}


		    return $this->get_results($search_query);
		}

		/* 
		 *  Data Structures "Getters and Setters"
		 */

		public function getViews($article_id)
		{
			return $this->get_var("SELECT article_views FROM article WHERE article_id = $article_id");
		}

		public function getTitle($article_id)
		{
			return $this->get_var("SELECT article_title FROM article WHERE article_id = $article_id");
		}

		public function setTitle($article_id, $newTitle)
		{
			$this->query("UPDATE article SET article_title = '$newTitle' WHERE article_id = $article_id");
		}

		public function getArticleType($article_id)
		{
			return $this->get_var("SELECT article_type FROM article WHERE article_id = $article_id");
		}

		public function setArticleType($article_id, $newType)
		{
			$this->query("UPDATE article SET article_type = '$newType' WHERE article_id = $article_id");
		}

		public function getArticleTypeName($article_id)
		{
			return $this->get_var("SELECT articletype.type_name FROM article INNER JOIN articletype ON (article.article_type = articletype.type_id) WHERE article_id = $article_id");
		}

		public function getArticleBody($article_id)
		{
			return $this->get_var("SELECT article_body FROM article WHERE article_id = $article_id");
		}

		public function setArticleBody($article_id, $newBody)
		{
			$this->query("UPDATE article SET article_body = '$newBody' WHERE article_id = $article_id");
		}

		public function getAuthor($article_id)
		{
			return $this->get_var("SELECT author FROM article WHERE article_id = $article_id");
		}

		public function setAuthor($article_id, $newAuthorID)
		{
			$this->query("UPDATE article SET author = '$newAuthorID' WHERE article_id = $article_id");
		}

		public function getMainPhotoURL($article_id)
		{
			return $this->get_var("SELECT articlephoto FROM article WHERE article_id = $article_id");
		}

		public function setMainPhotoURL($article_id, $newMainPhotoURL)
		{
			$this->query("UPDATE article SET articlephoto = '$newMainPhotoURL' WHERE article_id = $article_id");
		}

		public function getTeaser($article_id)
		{
			return $this->get_var("SELECT photo_caption FROM article WHERE article_id = $article_id");
		}

		public function setTeaser($article_id, $newTeaser)
		{
			$this->query("UPDATE article SET photo_caption = '$newTeaser' WHERE article_id = $article_id");
		}

		public function getSubmittedDate($article_id)
		{
			return $this->get_var("SELECT date_submitted FROM article WHERE article_id = $article_id");
		}

		public function getPublishedDate($article_id)
		{
			return $this->get_var("SELECT date_published FROM article WHERE article_id = $article_id");
		}
	}
?>