<?php
	$title = "Writer's Desk";
	require_once('template/silahis_sessionstarter.php');
	if (!isset($_SESSION['staff_id']))
	{
		header('Location: staff_login.php');
		exit();
	}
	require_once('template/silahis_header_staffpanel.php');
	require_once('template/silahis_nav_adminpanel.php');
	include_once('backend/DBConnection.php');
	require_once('backend/silahis_connectvars.php');
	$dbc = new DBConnection(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	$articlesArray = $dbc->get_results("SELECT article.status status, article.article_title title, article.article_id id FROM article WHERE deleted = false AND author = '" . $_SESSION['staff_id'] . "' ORDER BY article.date_submitted DESC");
?>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <?php require_once('template/silahis_navleft_adminpanel.php'); ?>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Writer's Desk
                    </h1>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Your Articles</h3>                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
								<a href="newarticle.php" class="btn btn-primary"><span class="ion-edit"></span> Write a new article</a>
                                    <table id="writersdesk" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
												<th>Title</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
												$rows = count($articlesArray);
											//	$columns = count($articlesArray[0]);
												for ($r = 0; $r < $rows; $r++)
												{
													echo '<tr>';										
													echo '<th><a href="staffpanel_viewarticle.php?article=' . $articlesArray[$r]['id'] . '">' . $articlesArray[$r]['title'] . '</a></th>';
													echo '<th>' . $articlesArray[$r]['status'] . '</th>';
													echo '</tr>';
												}
											?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Title</th>
                                                <th>Status</th>
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

        <!-- add new calendar event modal -->
<?php
	require_once('template/silahis_footer_staffpanel.php');
?>