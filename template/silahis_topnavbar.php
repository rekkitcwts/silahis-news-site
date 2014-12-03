<?php
  error_reporting(-1);
ini_set('display_errors', 'On');
?>
        <div class="container-fluid" style="margin-top: 51px;"> 
          <!-- Fixed navbar -->
          <div class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#main-nav">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="index.php"><img alt="Silahis Logo" src="img/SilahisHeader.png" style="margin-top:-15px; height: 50px;" /></a>
            </div>
            <div id="main-nav" class="navbar-collapse collapse">
              <ul class="nav navbar-nav navbar-right">
                <li><a href="http://msuiit.edu.ph">msuiit.edu.ph</a></li>
                <li><a href="http://my.iit.edu.ph">My.IIT</a></li>
                <li id="search">

                  <!-- Use of this code assumes agreement with the Google Custom Search Terms of Service. -->
                  <!-- The terms of service are available at http://www.google.com.au/cse/docs/tos.html -->
                  <form name="cse" id="searchbox_demo" action="http://www.google.com/cse">
                    <input type="hidden" name="cref" value="" />
                    <input type="hidden" name="ie" value="utf-8" />
                    <input type="hidden" name="hl" value="" />
                    <input name="q" type="text" size="40" />
                    <input type="submit" name="sa" value="Search" />
                  </form>
                  <script type="text/javascript" src="https://www.google.com.au/cse/tools/onthefly?form=searchbox_demo&lang="></script>
                </li> 
              </ul>
            </div><!--/.nav-collapse -->
          </div>