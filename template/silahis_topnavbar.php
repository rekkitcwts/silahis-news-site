	<!-- Fixed navbar -->
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php"><img alt="Silahis Logo" src="img/SilahisHeader.png" style="margin-top:-15px; height: 50px;" /></a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="http://msuiit.edu.ph">msuiit.edu.ph</a></li>
            <li><a href="http://my.iit.edu.ph">My.IIT</a></li>
            <li id="search">
            <form id="search-form" method="get" action="search.php">
              <input id="search-field" class="input-medium" type="text" maxlength="128" size="15" value="" name="search_string" placeholder="Search" title="Article search by title or body content">
              <button id="search-btn" formmethod="post" aria-label="Search" name="submit" type="submit">
                <i class="glyphicon glyphicon-search"></i>
              </button>
            </form>
            </li> 
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
    <!-- Navbar ends here -->