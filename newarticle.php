<?php
	$title = "New Article";
	include_once('backend/DBConnection.php');
	include_once('backend/Articles.php');
	require_once('backend/silahis_connectvars.php');
	$dbc = new DBConnection(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	$articleTypesArray = $dbc->get_results("SELECT * FROM articletype");
	require_once('template/silahis_sessionstarter.php');
	if (!isset($_SESSION['staff_id']))
	{
		header('Location: staff_login.php');
		exit();
	}
	require_once('template/silahis_header_staffpanel.php');
	require_once('template/silahis_nav_adminpanel.php');
?>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <?php require_once('template/silahis_navleft_adminpanel.php'); ?>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Write New Article
                    </h1>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Add Your Article</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
									<p>Please use the following entry form to write your article.</p>
									<?php
									if (isset($_POST['submitArticle'])) {
										$errors = array();
										$author = $_SESSION['staff_id'];
										$articletitle_unescaped = $_POST['title'];
										$articletitle = strip_tags(str_replace('\'', '\'\'', trim($_POST['title'])));
										$articleTypeID = $_POST['articleselection'];
										$articleBody = str_replace('<img ', '<img class="img-responsive" ', trim($_POST['articlebody']));
										$imagename = strip_tags(str_replace('\'', '\'\'', trim($_POST['articleimage'])));
										$caption = strip_tags(str_replace('\'', '\'\'', trim($_POST['imagecaption'])));
										if (empty($articletitle) && empty($articleBody) && empty($imagename) && empty($caption)) //title and body are empty, no images
										{
											// ERROR!
											$errors[] = "EMPTY_TITLE";
											$errors[] = "EMPTY_BODY";
											$errors[] = "IMG_REQUIRED";
											$errors[] = "TEASER_REQUIRED";
										}
										if (!empty($articletitle) && empty($articleBody)) // only body is empty
										{
											// ERROR!
											$errors[] = "EMPTY_BODY";
											if (empty($imagename))
											{
												// image is NOW required
												$errors[] = "IMG_REQUIRED";
											}
											if (empty($caption))
											{
												// teaser is NOW required
												$errors[] = "TEASER_REQUIRED";
											}
										}
										if (empty($articletitle) && !empty($articleBody)) // only title is empty
										{
											// ERROR!
											$errors[] = "EMPTY_TITLE";
											if (empty($imagename))
											{
												// image is NOW required
												$errors[] = "IMG_REQUIRED";
											}
											if (empty($caption))
											{
												// teaser is NOW required
												$errors[] = "TEASER_REQUIRED";
											}
										}
										if (!empty($articletitle) && !empty($articleBody) && empty($imagename))
										{
												// image is NOW required
												$errors[] = "IMG_REQUIRED";
												if (empty($caption))
												{
												// teaser is NOW required
												$errors[] = "TEASER_REQUIRED";
												}
										}
										if (!empty($articletitle) && !empty($articleBody) && !empty($imagename) && empty($caption))
										{
											// teaser is NOW required
											$errors[] = "TEASER_REQUIRED";
										}
										if (!empty($articletitle) && !empty($articleBody) && !empty($imagename) && !empty($caption)) //both title and body are not empty, and there are images
										{
											// OK!
											$insertArticle = new Article(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
											$newArticle = array('author' => $author, 'title' => $articletitle, 'type' => $articleTypeID, 'body' => $articleBody, 'main_image' => $imagename, 'teaser' => $caption);
											$insertArticle->createArticle($newArticle);
											//$insertArticle->createArticle($author, $articletitle, $articleTypeID, $articleBody, $imagename, $caption);

											$status = "AUSTRALIA";
											// clear the fields
											$articletitle_unescaped = "";
											$articleBody = "";
										//	pg_close($dbc);
										}
										if (count($errors) > 0)
										{
											echo '<div class="alert alert-danger" id="errormessages"><i class="fa fa-ban"></i><b>WARNING:</b> Please fix the errors first.<br />';
											for ($i = 0; $i < count($errors); $i++)
											{
												if ($errors[$i] == "EMPTY_TITLE")
													echo "You forgot your article's title. <br />";
												else if ($errors[$i] == "EMPTY_BODY")
													echo "You forgot your article's body. <br />";
												else if ($errors[$i] == "IMG_REQUIRED")
													echo "The photo for the article is required. <br />";
												else if ($errors[$i] == "INVALID_IMG_FORMAT")
													echo "The file should be a JPEG, GIF, or PNG image. <br />";
												else if ($errors[$i] == "TEASER_REQUIRED")
													echo "The article teaser is required. <br />";
												else
													echo $errors[$i] . '<br />';
											}
											echo '</div>';
										}
										else
										{
											echo '<div class="alert alert-success" id="errormessages"><i class="fa fa-check"></i><b>SUCCESS!</b><br />Your article has been submitted and is awaiting approval by the editors.';
											echo '</div>';
										}
									}
									?>
									<div id="imagetest"></div>
									<form name="articleuploader" id="articleuploader" method="POST" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>">
										<div class="form-group">
											<label for="title">Title/Headline</label>
											<input type="text" class="form-control" id="title" name="title" value="<?php if (!empty($articletitle_unescaped)) echo $articletitle_unescaped; ?>" />
										</div>
										<div class="form-group">
											<label for="articleselection">Article Section</label>
											<select class="form-control" id="articleselection" name="articleselection">
											<?php
												//while ($type = pg_fetch_assoc($articleTypeQuery))
												for ($i = 0; $i < count($articleTypesArray); $i++)
												{
													echo '<option value="' . $articleTypesArray[$i]['type_id'] . '">' . $articleTypesArray[$i]['type_name'] . '</option>';
												}
											?>
											</select>
										</div>
										<div class="form-group">
											<label for="articlebody">Body</label>
											<textarea id="articlebody" name="articlebody" rows="10" cols="80" placeholder="Enter the 'body' or 'text' of your story here.">
											<?php if (!empty($articleBody)) echo $articleBody; ?>
											</textarea>    
										</div>
										<div class="form-group">
											<label for="articleimage">Main Image</label>
										<!--	<input type="file" class="form-control" id="articleimage" name="articleimage" /> -->
											<input type="text" class="form-control" id="articleimage" name="articleimage" />
										</div>
										<div class="form-group">
											<label for="imagecaption">Teaser</label>
											<input type="text" class="form-control" id="imagecaption" name="imagecaption" />
										</div>
										<!--&nbsp;&nbsp;&nbsp;
										<div class="form-group">
											<div class="checkbox">
												<label>
													<input type="checkbox" id="terms" name="terms" value="agreed" /> I agree that I will be accountable for my article if in case legal action is taken by elitists and oligarchs.
												</label>
											</div>
										</div>-->
										<input type="submit" class="btn btn-primary" value="Submit article" name="submitArticle" />
										<!--<button type="button" class="btn btn-primary" id="submitArticle">Submit Article</button>-->
									</form>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>
                    
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <script>
            $(function() {
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                CKEDITOR.replace('articlebody', {
					filebrowserBrowseUrl : 'backend/elfinder-2.0-rc1-fixed/elfinder.php', // eg. 'includes/elFinder/elfinder.html'
					uiColor : '#9AB8F3',
					language: 'en-au',
					toolbar : 'Basic',
					allowedContent:
						'h1 h2 h3 p blockquote strong em;' +
						'a[!href];' +
						'img(img-responsive)[!src,alt];' +
						'table tr th td caption;' +
						'span{!font-family};' +
						'span{!color};' +
						'span(!marker);' +
						'del ins'
				});
				
            });
        </script>
<?php
	require_once('template/silahis_footer_staffpanel.php');
?>