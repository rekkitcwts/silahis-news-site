<?php
	error_reporting(-1);
	ini_set('display_errors', 'On');
?>
      		<div class="row">
      			<div class="col-md-3">
      				<div id="silahis-menu" class="article-sections">
      					<ul class="list-unstyled">
      						<li><a href="index.php"<?php if (empty($type)) echo ' class="active"'; else echo ' '; ?>>Home</a></li>
      						<li><a href="section.php?type=1" <?php if ($type=='News') echo ' class="active"'; else echo ' '; ?>>News</a></li>
						<li><a href="section.php?type=2" <?php if ($type=='Feature') echo ' class="active"'; else echo ' '; ?>>Feature</a></li>
						<li><a href="section.php?type=3" <?php if ($type=='Opinion') echo ' class="active"'; else echo ' '; ?>>Opinion</a></li>
						<li><a href="section.php?type=4" <?php if ($type=='Literary') echo ' class="active"'; else echo ' '; ?>>Literary</a></li>
						<li><a href="section.php?type=5" <?php if ($type=='Editorial') echo ' class="active"'; else echo ' '; ?>>Editorial</a></li>
      					</ul>
      				</div>
      			</div>


      			<div class="col-md-9">
      				<div class="col-sm-12 col-md-8 col-lg-8">