<?php
	$title = "Add New Staff Member";
	require_once('template/silahis_sessionstarter.php');
	if (!isset($_SESSION['staff_id']))
	{
		header('Location: staff_login.php');
		exit();
	}
	//require_once('template/silahis_adviserchecker.php');
	include_once('backend/DBConnection.php');
	require_once('template/silahis_header_staffpanel.php');
	require_once('template/silahis_nav_adminpanel.php');
	require_once('backend/silahis_connectvars.php');
//	$dbc = pg_connect("host=".DB_HOST." user=".DB_USER." password=".DB_PASSWORD." dbname=".DB_NAME);
//	$positions = pg_query($dbc, "SELECT * FROM position");
	$dbc = new DBConnection(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	$positions = $dbc->get_results("SELECT * FROM position");
?>
<div class="wrapper row-offcanvas row-offcanvas-left">
	<?php require_once('template/silahis_navleft_adminpanel.php'); ?>
	<aside class="right-side">                
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Manage Users
                    </h1>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Add a new user</h3>                                    
                                </div><!-- /.box-header -->
                                <div class="box-body">
									<div id="addusererrormessage">
                                    </div>
                                    <form role="form">
										<div class="form-group">
											<label for="fname">First Name <span class="text-danger" id="fNameError"></span></label>
											<input type="text" class="form-control" id="fname" onblur="validateNonEmpty(this, document.getElementById('fNameError'));" />
										</div>
										<div class="form-group">
											<label for="lname">Last Name <span class="text-danger" id="lNameError"></span></label>
											<input type="text" class="form-control" id="lname" onblur="validateNonEmpty(this, document.getElementById('lNameError'));" />
										</div>
										<div class="form-group">
											<label for="positionDesired">Position</label>
											<select class="form-control" name="positionDesired" id="positionDesired">
											<?php
											//	while($position = pg_fetch_assoc($positions))
												for ($i = 0; $i < count($positions); $i++)
												{
													echo '<option value="' . $positions[$i]['position_id'] . '">' . $positions[$i]['position_name'] . '</option>';
												}
											?>
											</select>
										</div>
										<div class="form-group">
											<label for="username">Username <span class="text-danger" id="usernameError"></span></label>
											<input type="text" class="form-control" id="username" onblur="validateLength(8, 40, this, document.getElementById('usernameError'));" />
										</div>
										<div class="form-group">
											<label for="password1">Password <span class="text-danger" id="password1Error"></span></label>
											<input type="password" class="form-control" id="password1" onblur="validateLength(8, 20, this, document.getElementById('password1Error'));" />
										</div>
										<div class="form-group">
											<label for="password2">Confirm Password <span class="text-danger" id="password2Error"></span></label>
											<input type="password" class="form-control" id="password2" onblur="validateLength(8, 20, this, document.getElementById('password2Error'));" />
										</div>
										<button type="button" id="addNewUser" class="btn btn-primary">Add</button>
									</form>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
</div>
<?php
	require_once('template/silahis_footer_staffpanel.php');
?>