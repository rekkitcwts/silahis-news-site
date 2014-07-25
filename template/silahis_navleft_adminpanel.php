<!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="img/staff/admin.png" class="img-circle" alt="User Image" />
                        </div>
                        <div class="pull-left info">
                            <p>Hello, <?php echo $first_name; ?></p>
							<a href="#">Edit Profile</a>
                        </div>
                    </div>
                    
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li>
							<?php 
							if (($position_name == "Adviser") || ($position_name == "Editor-In-Chief"))
							{
							?>
                            <a href="adminpanel.php">
                                <i class="fa fa-dashboard"></i> <span>Adviser Dashboard</span>
                            </a>
							<?php
							}
							?>
							<?php 
							if (($position_name == "News Editor") || ($position_name == "Feature Editor") || ($position_name == "Associate Editor"))
							{
							?>
                            <a href="editor_dashboard.php">
                                <i class="fa fa-dashboard"></i> <span>Editor Dashboard</span>
                            </a>
							<?php
							}
							?>
							<?php 
							if (($position_name == "News Writer") || ($position_name == "Feature Writer"))
							{
							?>
                            <a href="writer_dashboard.php">
                                <i class="fa fa-dashboard"></i> <span>Writer Dashboard</span>
                            </a>
							<?php
							}
							?>
                        </li>
						<?php 
							if (($position_name == "Adviser") || ($position_name == "Editor-In-Chief") || ($position_name == "News Editor") || ($position_name == "Feature Editor") || ($position_name == "Associate Editor"))
							{
							?>
						<li>
                            <a href="editor_corkboard.php">
                                <i class="fa fa-th"></i> <span>Editor's Corkboard</span>
                            </a>
                        </li>
						<?php
							}
							?>
						<li>
                            <a href="writer_desk.php">
                                <i class="fa fa-th"></i> <span>Writer's Desk</span>
                            </a>
                        </li>
						<?php 
							if (($position_name == "Adviser") || ($position_name == "Editor-In-Chief"))
							{
							?>
                        <li>
                            <a href="admin_manageusers.php">
                                <i class="fa fa-th"></i> <span>Manage Staff</span>
                            </a>
                        </li>
					<!--	<li>
                            <a href="#">
                                <i class="fa fa-th"></i> <span>Manage Positions</span>
                            </a>
                        </li> -->
						<?php
							}
							?>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>