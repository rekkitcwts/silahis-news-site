<?php
require_once('template/silahis_sessionstarter.php');
require_once('template/silahis_editorchecker.php');
	$title = "Editor's Corkboard";
	
	if (!isset($_SESSION['staff_id']))
	{
		header('Location: staff_login.php');
		exit();
	}
	require_once('template/silahis_header_staffpanel.php');
	require_once('template/silahis_nav_adminpanel.php');
	include_once('backend/DBConnection.php');

    require_once('backend/anti_csrf.php');

    $csrf = new AntiCSRF();
 
 
    // Generate Token Id and Valid
    $token_id = $csrf->get_token_id();
    $token_value = $csrf->get_token($token_id);
//	require_once('backend/silahis_connectvars.php');
	$dbc = new DBConnection(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	$articlesArray = $dbc->get_results("SELECT article.article_title, article.article_id, staff.staff_lname, staff.staff_fname, articletype.type_name, article.date_submitted FROM article INNER JOIN articletype ON (article.article_type = articletype.type_id) INNER JOIN staff ON (article.author = staff.staff_id) WHERE deleted = 'false' ORDER BY article.date_submitted DESC");
?>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <?php require_once('template/silahis_navleft_adminpanel.php'); ?>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Editor's Corkboard
                    </h1>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Articles to be reviewed</h3>                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="tbedited" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
												<th>Title</th>
                                                <th>Article Type</th>
                                                <th>Author</th>
                                                <th>Date Submitted</th>
                                                <th>Options</th>
                                            </tr>
                                        </thead>
                                        <tbody id="yourarticles">
                                            <?php
												$rows = count($articlesArray);
											//	$columns = count($articlesArray[0]);
												for ($r = 0; $r < $rows; $r++)
												{
													echo '<tr>';										
													echo '<th><a href="editor_editarticle.php?article=' . $articlesArray[$r]['article_id'] . '">' . $articlesArray[$r]['article_title'] . '</a></th>';
													echo '<th>' . $articlesArray[$r]['type_name'] . '</th>';
                                                    echo '<th>' . $articlesArray[$r]['staff_fname'] . ' ' . $articlesArray[$r]['staff_lname'] . '</th>';
                                                    $time = strtotime($articlesArray[$r]['date_submitted']);
                                                    echo '<th>' . date('jS F Y, g:i:s A',$time) . '</th>';
                                                    echo '<th>';
                                                    echo '<button class="btn btn-danger btn-sm" onclick="showRemoveArticleModal(' . $articlesArray[$r]['article_id'] . ');">';
                                                    echo 'Remove this article';
                                                    echo '</button></th>';
													echo '</tr>';
												}
											?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Title</th>
                                                <th>Article Type</th>
                                                <th>Author</th>
                                                <th>Date Submitted</th>
                                                <th>Options</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>
                    
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

<!-- Remove Article Modal -->
<div class="modal fade" id="articleRemoveDialog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Confirm</h4>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to remove this article? This cannot be undone.</p>
        <input type="hidden" name="token" id="token" value="<?php echo $token_value; ?>" />
        <input type="hidden" name="articleIDhidden" id="articleIDhidden" value="" />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btnConfirmRemoveArticle">Yes</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>
<?php
	require_once('template/silahis_footer_staffpanel.php');
?>