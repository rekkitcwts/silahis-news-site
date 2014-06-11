<?php
	session_start();
	if (isset($_SESSION['staff_id']))
	{
		//header('Location: adminpanel.php');
		exit('Already logged in');
	}
	
	require_once('template/silahis_header.php');
	require_once('backend/silahis_connectvars.php');
?>
<div class="container">
	<div class="row">
		<div class="col-md-2"><!-- Whitespace --></div>
		<div class="col-md-8">
			<div id="loginForm" class="text-center"> 
				<div id="message" class="text-center">
					<br />
					<br />
					<br />
					<form class="form-horizontal" role="form">
						<div class="form-group">
							<div class="col-md-8 col-md-offset-2">
								<input type="text" class="form-control" name="staff_user" id="username" placeholder="Username" />
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-8 col-md-offset-2">
								<input type="password" class="form-control" name="staff_pass" id="password" placeholder="Password" />
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-8 col-md-offset-2">
								<button type="button" id="staffLogin" class="btn btn-primary">Login</button>
							</div>
						</div>
					</form>
					<p id="loginError"></p>
					<br />
					<!--[if lt IE 9]>
						<p>You are using an old version of Internet Explorer.</p>
						<p>Please use a modern browser like Mozilla Firefox or Google Chrome.</p>
					<![endif]-->
					<!--[if !IE]
						<p>Preparing to dispense product.</p>
					<![endif]-->
					<p>Please use Google Chrome or Mozilla Firefox.</p>
				</div>
			</div>
		</div>
		<div class="col-md-2"><!-- Whitespace --></div>
		</div>
</div>
<?php
	require_once('template/silahis_footer.php');
?>