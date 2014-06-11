<?php
	$curtime = date('l, j F Y, g:i A (e)');
?>
<div id="timeAndSearchArea">
	<div class="row">
		<div class="container">
			<div class="col-md-12">
				<div class="col-sm-8">
					<p>Today is <?php echo $curtime;?></p>
				</div>
				<div class="col-sm-4">
					<form method="GET" action="search.php">
						<div class="input-group">
							<input type="text" class="form-control input-sm" name="search" />
								<span class="input-group-btn">
									<button class="btn btn-danger btn-sm" type="submit">Search!</button>
								</span>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>