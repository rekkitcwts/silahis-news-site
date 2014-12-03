<?php
require_once('template/silahis_sessionstarter.php');
require_once('template/silahis_editorchecker.php');
	if (is_numeric($_GET['article']))
	{
		$articleID = $_GET['article'];
	}
	else
	{
		header("Location: index.php");
		exit();
	}
	include_once('backend/DBConnection.php');
	include_once('backend/Articles.php');
	require_once('backend/silahis_connectvars.php');
	$dbc = new DBConnection(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	$articleTypesArray = $dbc->get_results("SELECT * FROM articletype");
	$articleArray = $dbc->get_row("SELECT * FROM article WHERE article_id = " . $articleID);

	$currentArticleTitle = $articleArray['article_title'];
	$currentArticleBody = $articleArray['article_body'];
	$currentArticleType = $articleArray['article_type'];
	$currentArticlePhotoURL = $articleArray['articlephoto'];
	$currentArticleTeaser = $articleArray['photo_caption'];
	$currentStatus = $articleArray['status'];
	
	$title = "Editing Article \"" . $currentArticleTitle . "\"";
	require_once('template/silahis_sessionstarter.php');
	if (!isset($_SESSION['staff_id']))
	{
		header('Location: staff_login.php');
		exit();
	}
	require_once('template/silahis_header_staffpanel.php');
	require_once('template/silahis_nav_adminpanel.php');
	require_once('backend/anti_csrf.php');

	$csrf = new AntiCSRF();
 
 
	// Generate Token Id and Valid
	$token_id = $csrf->get_token_id();
	$token_value = $csrf->get_token($token_id);
?>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <?php require_once('template/silahis_navleft_adminpanel.php'); ?>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Edit Article
                    </h1>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Now Editing: "<?php echo $currentArticleTitle; ?>"</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
									<?php
									error_reporting(E_ALL); 
									ini_set('display_errors','On');
									if (isset($_POST['submitArticle'])) {
										$errors = array();
										$articletitle_unescaped = $_POST['title'];
										$articletitle = strip_tags(str_replace('\'', '\'\'', trim($_POST['title'])));
										$articleTypeID = $_POST['articleselection'];
										$articleBody = trim($_POST['articlebody']);
										$imagename = strip_tags(str_replace('\'', '\'\'', trim($_POST['articleimage'])));
										$caption = strip_tags(str_replace('\'', '\'\'', trim($_POST['imagecaption'])));
										$verdict = trim($_POST['verdict']);
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
										if (!$csrf->check_valid('post', false)) 
										{
											$errors[] = "CSRF";
										}
										if ($csrf->check_valid('post', false) && !empty($articletitle) && !empty($articleBody) && !empty($imagename) && !empty($caption)) //both title and body are not empty, and there are images
										{
											// OK!
											$updateArticle = new Article(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
											$updateArticle->setTitle($articleID, $articletitle);
											$updateArticle->setArticleType($articleID, $articleTypeID);
											$updateArticle->setArticleBody($articleID, $articleBody);
											$updateArticle->setMainPhotoURL($articleID, $imagename);
											$updateArticle->setTeaser($articleID, $caption);
											if ($verdict == "Published")
											{
												$updateArticle->publishArticle($articleID);
											}

											// clear the fields
											$articletitle_unescaped = "";
											$articleBody = "";
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
												else if ($errors[$i] == "CSRF")
													echo "Cross-site forgery detected!. <br />";
												else
													echo $errors[$i] . '<br />';
											}
											echo '</div>';
										}
										else
										{
											if (isset($_POST['verdict']) && ($_POST['verdict'] == 'Published'))
											{
												echo '<div class="alert alert-success" id="errormessages"><i class="fa fa-check"></i><b>SUCCESS!</b><br />Your changes have been saved and the article is now live on the site.';
												echo '</div>';
											}
											else
											{
												echo '<div class="alert alert-success" id="errormessages"><i class="fa fa-check"></i><b>SUCCESS!</b><br />Your changes have been saved.';
												echo '</div>';
											}
										}
									}
									?>
									<div id="imagetest"></div>
									<form name="articleuploader" id="articleuploader" method="POST" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF'] . '?article=' . $articleID; ?>">
										<input type="hidden" id="token" name="<?php echo $token_id; ?>" value="<?php echo $token_value; ?>" />
										<div class="form-group">
											<label for="title">Title/Headline</label>
											<input type="text" class="form-control" id="title" name="title" value="<?php if (isset($articletitle)) echo ($articletitle); else echo ($currentArticleTitle); ?>" />
										</div>
										<div class="form-group">
											<label for="articleselection">Article Section</label>
											<select class="form-control" id="articleselection" name="articleselection">
											<?php
												//while ($type = pg_fetch_assoc($articleTypeQuery))
												for ($i = 0; $i < count($articleTypesArray); $i++)
												{
													echo '<option '; 
													if ($articleTypesArray[$i]['type_id'] == $currentArticleType) echo 'selected="selected" ';
													echo 'value="' . $articleTypesArray[$i]['type_id'] . '">' . $articleTypesArray[$i]['type_name'] . '</option>';
												}
											?>
											</select>
										</div>
										<div class="form-group">
											<label for="articlebody">Body</label>
											<textarea id="articlebody" name="articlebody" rows="10" cols="80" placeholder="Enter the 'body' or 'text' of your story here.">
												<?php if (isset($_POST['articlebody'])) echo $_POST['articlebody']; else echo ($currentArticleBody); ?>
											</textarea>    
										</div>
										<div class="form-group">
											<label for="articleimage">Main Image</label>
											<input type="text" class="form-control" id="articleimage" name="articleimage" value="<?php if (isset($imagename)) echo $imagename; else echo $currentArticlePhotoURL; ?>" />
										</div>
										<div class="form-group">
											<label for="imagecaption">Teaser</label>
											<input type="text" class="form-control" id="imagecaption" name="imagecaption" value="<?php if (isset($caption)) echo $caption; else echo $currentArticleTeaser; ?>" />
										</div>
										<div class="form-group">
											<label for="verdict">Publish this article?</label>
											<select class="form-control" id="verdict" name="verdict">
												<?php
												if (isset($_POST['verdict']))
												{
													echo '<option';
													if ($_POST['verdict'] == "Published")
													{
														echo ' selected="selected" ';
													}
													else
													{
														echo ' ';
													}
													echo 'value="Published">Yes</option>';
													echo '<option';
													if ($_POST['verdict'] == "Pending")
													{
														echo ' selected="selected" ';
													}
													else
													{
														echo ' ';
													}
													echo 'value="Pending">No</option>';
												}
												else
												{
													echo '<option';
													if ($currentStatus == "Published")
													{
														echo ' selected="selected" ';
													}
													else
													{
														echo ' ';
													}
													echo 'value="Published">Yes</option>';
													echo '<option';
													if ($currentStatus == "Pending")
													{
														echo ' selected="selected" ';
													}
													else
													{
														echo ' ';
													}
													echo 'value="Pending">No</option>';
												}
												?>
											</select>
										</div>
										<input type="submit" class="btn btn-primary" value="Save Changes" name="submitArticle" />
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