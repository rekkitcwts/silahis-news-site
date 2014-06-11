<?php
	require_once('backend/silahis_connectvars.php');
    include('backend/Staff.php');
    include('backend/Student.php');
    $dbcStaff = new Staff(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $dbcStudent = new Student(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $staff_id = $_SESSION['staff_id'];
    $position_name = $dbcStaff->getCurrentPositionName($staff_id);
    $first_name = $dbcStudent->getFirstName($staff_id);
    $last_name = $dbcStudent->getLastName($staff_id);
?>
<!-- Nav for Admin Panel only -->
<!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="
            <?php
                if ($position_name == 'Adviser' || $position_name == 'Editor-In-Chief')
                echo 'adminpanel.php';
                else
                {
                   echo '#';
                } 
            ?>" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                Silahis
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
								<!-- Profile Name -->
                                <span><?php echo $first_name . ' ' . $last_name; ?> <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue">
                                    <img src="img/staff/admin.png" class="img-circle" alt="User Image" />
                                    <p>
										<!-- Name - Position -->
                                        <?php echo $first_name . ' ' . $last_name . ' - ' . $position_name; ?>
                                        <small>Member since 
										<?php
											$originalDate = $dbcStaff->getStartDate($staff_id);
											$newDate = date("j M Y", strtotime($originalDate));
											echo $newDate; 
										?></small>
                                    </p>
                                </li>       
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="#" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="staff_logout.php" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>