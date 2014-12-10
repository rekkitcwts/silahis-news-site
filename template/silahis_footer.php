     		</div>
      </div>
</div>
<div class="row">
<div class="col-sm-12 col-md-12 col-lg-12">
                              <p>Copyright &copy; 2014
                              <a class="footlink" href="http://www.msuiit.edu.ph">Mindanao State University — Iligan Institute of Technology</a>
                              <?php
   $mtime = microtime();
   $mtime = explode(" ",$mtime);
   $mtime = $mtime[1] + $mtime[0];
   $endtime = $mtime;
   $totaltime = ($endtime - $starttime);
   echo "<p>Page loaded in ".$totaltime." seconds</p>";
;?>
                              </p>
                        </div>
                  </div>
      	</div> <!-- container-fluid -->
                        
      	<script src="js/jquery-1.10.2.js"></script>
      	<script src="js/bootstrap.js"></script>
      	<!--<script src="js/plugins/ckeditor/ckeditor.js"></script>-->
      	<script src="js/docready.js"></script>
      	<script src="js/functions.js"></script>
	</body>
</html>