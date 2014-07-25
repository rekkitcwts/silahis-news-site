<?php
    require_once('silahis_backendsecurity.php');
	require_once('silahis_connectvars.php');
    include_once('DBConnection.php');
    if (!is_numeric($_GET['iDisplayLength']))
    {
    	echo 'Illegal operation.';
    	exit();
    }
    $search = strip_tags(str_replace('\'', '\'\'', trim($_GET['sSearch'])));

    $search_query = "SELECT * FROM staff";

    // Extract the search keywords into an array
    $clean_search = str_replace(',', ' ', $search);
    $search_words = explode(' ', $clean_search);
    $final_search_words = array();
    if (count($search_words) > 0) {
      foreach ($search_words as $word) {
        if (!empty($word)) {
          $final_search_words[] = $word;
        }
      }
    }

    // Generate a WHERE clause using all of the search keywords
    $where_list = array();
    if (count($final_search_words) > 0) {
      foreach($final_search_words as $word) {
        $where_list[] = "LOWER(staff_id) LIKE LOWER('%$word%') OR LOWER(staff_fname) LIKE LOWER('%$word%') OR LOWER(staff_lname) LIKE LOWER('%$word%')";
      }
    }
    $where_clause = implode(' OR ', $where_list);

    // Add the keyword WHERE clause to the search query
    if (!empty($where_clause)) {
      $search_query .= " WHERE ($where_clause) AND (staff.staff_id IN (SELECT staff_position.staff_id FROM staff_position))";
    }
    else
    {
    	$search_query .= " WHERE staff.staff_id IN (SELECT staff_position.staff_id FROM staff_position)";
    }

    $dbc = new DBConnection(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
//    $constituentArray = $dbc->get_results("SELECT * FROM staff WHERE staff_id NOT IN (SELECT staff_position.staff_id FROM staff_position)");
    $constituentArray = $dbc->get_results($search_query);
    $rows = array();
    for ($i = 0; $i < count($constituentArray); $i++)
	{
		$rows[$i]['staff_id'] = $constituentArray[$i]['staff_id'];
		$rows[$i]['staff_fname'] = $constituentArray[$i]['staff_fname'];
		$rows[$i]['staff_lname'] = $constituentArray[$i]['staff_lname'];
		$rows[$i]['staff_id2'] = $constituentArray[$i]['staff_id'];
	}

	$result = array();
	// DEBUG PURPOSES
	//$result['queryWhat'] = $search_query;
	$result['aaData'] = $rows;
	$result['sEcho'] = (int) $_GET['sEcho'];
	$result['iTotalRecords'] = count($constituentArray);
	$result['iTotalDisplayRecords'] = $_GET['iDisplayLength'];
	print json_encode($result);
?>