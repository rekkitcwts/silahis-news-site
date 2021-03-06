<?php
error_reporting(-1);
ini_set('display_errors', 'On');
require_once('template/silahis_sessionstarter.php');
    require_once('template/silahis_adviserchecker.php');

	$title = "Admin Panel";
	
	if (!isset($_SESSION['staff_id']))
	{
		header('Location: staff_login.php');
		exit();
	}
	require_once('template/silahis_header_staffpanel.php');
	require_once('template/silahis_nav_adminpanel.php');
    require_once('backend/silahis_connectvars.php');
    include_once('backend/Articles.php');
    $dbc = new Article(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $num_pending = $dbc->getNumOfArticles('pending');
    $num_live = $dbc->getNumOfArticles('live');
    $num_deleted = $dbc->getNumOfArticles('deleted');

//	echo $_SESSION['staff_username'];
?>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <?php require_once('template/silahis_navleft_adminpanel.php'); ?>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Dashboard
                        <small>Control panel</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Dashboard</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h3>
                                        <?php echo $num_pending; ?>
                                    </h3>
                                    <p>
                                        Pending Articles
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="#" class="small-box-footer" title="These are the articles submitted in which they aren't checked by the editors">
                                    More info <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <h3>
                                        <?php echo $num_live; ?>
                                    </h3>
                                    <p>
                                        Approved Articles
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="#" class="small-box-footer" title="These are the articles live on the site.">
                                    More info <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-red">
                                <div class="inner">
                                    <h3>
                                        <?php echo $num_deleted; ?>
                                    </h3>
                                    <p>
                                        Deleted Articles
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-trash-a"></i>
                                </div>
                                <a href="#" class="small-box-footer" title="Articles that were deleted regardless of publishing status">
                                    More info <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                    </div><!-- /.row -->

                    <!-- top row -->
                    <div class="row">
                        <div class="col-xs-12 connectedSortable">
                            
                        </div><!-- /.col -->
                    </div>
                    <!-- /.row -->

                    
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <!-- add new calendar event modal -->
<?php
	require_once('template/silahis_footer_staffpanel.php');
?>