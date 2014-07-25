<?php
error_reporting(-1);
ini_set('display_errors', 'On');
require_once('template/silahis_sessionstarter.php');
    require_once('template/silahis_adviserchecker.php');

	$title = "Manage Staff Members";
	require_once('backend/silahis_connectvars.php');
    include_once('backend/DBConnection.php');
    $dbc = new DBConnection(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $constituentArray = $dbc->get_results("SELECT * FROM staff WHERE staff_id NOT IN (SELECT staff_position.staff_id FROM staff_position)");
    $positions = $dbc->get_results("SELECT * FROM position");
	
	if (!isset($_SESSION['staff_id']))
	{
		header('Location: staff_login.php');
		exit();
	}
//	require_once('template/silahis_adviserchecker.php');
	require_once('template/silahis_header_staffpanel.php');
	require_once('template/silahis_nav_adminpanel.php');

//	echo $_SESSION['staff_username'];
?>
<div class="wrapper row-offcanvas row-offcanvas-left">
	<?php require_once('template/silahis_navleft_adminpanel.php'); ?>
	<aside class="right-side">                
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Manage Staff Members
                    </h1>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-lg-6 connectedSortable">
                            <div class="box box-danger">
                                <div class="box-header">
                                    <div class="pull-right box-tools">
                                        <button class="btn btn-danger btn-sm" data-widget='collapse' data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                                    <!--    <button class="btn btn-danger btn-sm" data-widget='remove' data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button> -->
                                    </div><!-- /. tools -->
                                    <h3 class="box-title">Students List</h3>                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
								<!--<a href="admin_adduser.php">Add a new staff member</a>-->
                                    <table id="students" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID Number</th>
												<th>First Name</th>
                                                <th>Last Name</th>
												<th>Profile</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
											//	while($row = pg_fetch_assoc($staffquery))
                                        /*        for ($i = 0; $i < count($constituentArray); $i++)
												{
													echo '<tr>';
                                                    echo '<th>' . $constituentArray[$i]['staff_id'] . '</th>';
													echo '<th>' . $constituentArray[$i]['staff_fname'] . '</th>';
													echo '<th>' . $constituentArray[$i]['staff_lname'] . '</th>';
                                                    echo '<th><button type="button" class="btn btn-md btn-primary profile" data-idno="' . $constituentArray[$i]['staff_id'] . '">Profile</button></th>';
													echo '</tr>';
												}  */
											?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>ID Number</th>
                                                <th>First Name</th>
												<th>Last Name</th>
												<th>Profile</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                        <div class="col-lg-6 connectedSortable">
                            <div class="box box-danger">
                                <div class="box-header">
                                    <div class="pull-right box-tools">
                                        <button class="btn btn-danger btn-sm" data-widget='collapse' data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                                        <!--    <button class="btn btn-danger btn-sm" data-widget='remove' data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button> -->
                                    </div><!-- /. tools -->
                                    <h3 class="box-title">Student Info</h3>                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <!--<p>ID Number:</p>-->
                                    <p id="idno">Please select a student from the table at the left</p>
                                    <input type="hidden" name="idnoHidden" id="idnoHidden" value="" />
                                    <div class="form-group">
                                            <label for="positionDesired">Position</label>
                                            <select class="form-control" name="positionDesired" id="positionDesired">
                                            <?php
                                            //  while($position = pg_fetch_assoc($positions))
                                                for ($i = 0; $i < count($positions); $i++)
                                                {
                                                    echo '<option value="' . $positions[$i]['position_id'] . '">' . $positions[$i]['position_name'] . '</option>';
                                                }
                                            ?>
                                            </select>
                                    </div>
                                    <button type="button" class="btn btn-lg btn-primary" id="addtoBoard">Add to Editorial Board</button>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>
                    <div class="row">
                       <div class="col-lg-6 connectedSortable">
                            <div class="box box-danger">
                                <div class="box-header">
                                    <div class="pull-right box-tools">
                                        <button class="btn btn-danger btn-sm" data-widget='collapse' data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                                    <!--    <button class="btn btn-danger btn-sm" data-widget='remove' data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button> -->
                                    </div><!-- /. tools -->
                                    <h3 class="box-title">Staff Members</h3>                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                <!--<a href="admin_adduser.php">Add a new staff member</a>-->
                                    <table id="curstaffs" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID Number</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Profile</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Let AJAX do things here, mate. -->
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>ID Number</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Profile</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                        <div class="col-lg-6 connectedSortable">
                            <div class="box box-danger">
                                <div class="box-header">
                                    <div class="pull-right box-tools">
                                        <button class="btn btn-danger btn-sm" data-widget='collapse' data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                                    <!--    <button class="btn btn-danger btn-sm" data-widget='remove' data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button> -->
                                    </div><!-- /. tools -->
                                    <h3 class="box-title">Staff Profile</h3>                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                <!--<a href="admin_adduser.php">Add a new staff member</a>-->
                                    <p id="staffProfileArea">Please select a staff member from the table on the left</p>
                                    <div id="staffConfirmation">
                                        <div id="staffConfirmationQuestion"></div>
                                        <div id="staffConfirmationChoices"></div>
                                    </div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
</div>
<script>
    // scripts that are only exclusive to this page

</script>
<?php
	require_once('template/silahis_footer_staffpanel.php');
?>