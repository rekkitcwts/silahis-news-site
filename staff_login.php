<?php
	session_start();
	if (isset($_SESSION['staff_id']))
	{
		//header('Location: adminpanel.php');
		exit('Already logged in');
	}
	
	require_once('template/silahis_header.php');
	require_once('backend/silahis_connectvars.php');
	require_once('backend/anti_csrf.php');

	$csrf = new AntiCSRF();
 
 
	// Generate Token Id and Valid
	$token_id = $csrf->get_token_id();
	$token_value = $csrf->get_token($token_id);

?>
<link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />
<div class="container">
	<div class="row">
<!--		<div class="col-md-2"> </div>
		<div class="col-md-8">
			<div id="loginForm" class="text-center"> 
				<div id="message" class="text-center">
					<br />
					<br />
					<br />
					<form class="form-horizontal" role="form">
						<input type="hidden" id="token" name="<?php echo $token_id; ?>" value="<?php echo $token_value; ?>" />
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
					<p>
						<?php
							$user_agent = $_SERVER['HTTP_USER_AGENT'];
							if (preg_match("/msie/i", $user_agent)) 
							{
								echo "Please upgrade your Internet Explorer, or use a modern browser like Firefox.";
							} 
							else 
							{
								echo 'Good, standard browser detected.';
							}
							
						?>
					</p>
				</div>
			</div>
		</div>
		<div class="col-md-2"> </div> -->
		<div class="form-box" id="login-box">
 			<div class="header">Sign In</div>
				<form class="form-horizontal" role="form">
					<input type="hidden" id="token" name="<?php echo $token_id; ?>" value="<?php echo $token_value; ?>" />
 					<div class="body bg-gray">
 					<div class="form-group">
 						<input type="text" class="form-control" name="staff_user" id="username" placeholder="Username" />
 					</div>
 					<div class="form-group">
 						<input type="password" class="form-control" name="staff_pass" id="password" placeholder="Password" />
 					</div>          
 					</div>
 				</form>
 		<div class="footer">                                                               
 			<button type="button" id="staffLogin" class="btn bg-olive btn-block">Login</button>
 		</div>

 		</div>

 		<p id="loginError"></p>
	</div>
</div>
<?php
	require_once('template/silahis_footer.php');
?>