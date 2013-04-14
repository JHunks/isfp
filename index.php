<?php
include_once("includes/login/include/session.php"); 
error_reporting(E_ALL);
$connect = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die(mysql_error());
mysql_select_db(DB_NAME, $connect) or die(mysql_error());
$q = "SELECT * FROM settings";
$result = mysql_query($q, $connect);
$dbarray = mysql_fetch_array($result);
?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title> <?php echo $dbarray['site_title'] ?></title>
		<link rel="icon" href="assets/images/favicon.ico" type="image/x-icon"> 
		<link rel="shortcut icon" href="assets/images/favicon.ico" type="image/x-icon"> 
		<link rel="stylesheet" type="text/css" media="screen" href="assets/css/index.css">
		<link rel="stylesheet" href="includes/jQuery.isc/jQuery.isc.css" type="text/css" media="screen" charset="utf-8">
		<link rel="stylesheet" type="text/css" media="screen" href="includes/fullcalendar/fullcalendar.css">
		<link rel="stylesheet" type="text/css" media="screen" href="assets/css/buttons.css">
		<script src="http://www.google.com/jsapi"></script>
		<script>google.load("jquery", "1");</script>
		<script type="text/javascript">
		if (typeof jQuery == 'undefined'){
				document.write(unescape("%3Cscript src='includes/jQuery.js' type='text/javascript'%3e%3C/script%3E"));
			}
		</script>
		<script src="includes/jquery.ez-pinned-footer.js" type="text/javascript" charset="utf-8"></script>
		<script src="includes/jQuery.isc/jquery-image-scale-carousel.js" type="text/javascript" charset="utf-8"></script>
		<script src="includes/ckeditor/ckeditor.js" type="text/javascript" ></script>
		<script type='text/javascript' src='includes/fullcalendar/fullcalendar.js'></script>
		<script src="includes/jquery.validate.js" type="text/javascript" charset="utf-8"></script>
		<script type="text/javascript">
			<?php
				if ($dir = opendir('assets/carousel/')) {
					echo 'var carousel_images = [';
					while ($file = readdir($dir)) {
						list($fileName, $fileExt) = explode('.', $file);
						if (($fileExt == 'jpg') || ($fileExt == 'gif') || ($fileExt == 'png') || ($fileExt == 'jpeg')) {
							echo '"assets/carousel/' . $file . '",';
						}
				    }
					echo ']';
				    closedir($dir);
				}
			?>

			$(window).load(function() {
				$("#photo_container").isc({
					imgArray: carousel_images,
					autoplay: true,
					autoplayTimer: 5000
				});	
				$("#footer").pinFooter();
			});

			$(window).resize(function() {
			    $("#footer").pinFooter();
			});
		</script>
	</head>
	<body>
		<div id="container">
			<div id="title_logo"><a href="index.php"><img src="assets/images/logo.png"></a><h1><?php echo $dbarray['site_name']; ?></h1></div>
			<div id="header">
				<div id="photo_container"></div> 
			</div>
			<div id="content">
				<table>
					<tr>
						<td rowspan="3">
							<div id="login">
								<div id="login_title">
									<?php if($session->logged_in){ echo "<b>$session->username</b> - Online";} else {echo "Member";} ?>
								</div>
								<div id="login_content">
								<?php
									include("modules/login.php"); 
								?>
								</div>
							</div>
							<div id="navigation">
								<div id="nav_title">
									navigation
								</div>
								<div id="nav_content">
									
									<ol id="list_container">
										
										<li id="list_links"><a href="index.php?op=home">Home</a></li>
										<li id="list_links"><a href="index.php?op=about_us">About Us</a></li>
										<li id="list_links"><a href="index.php?op=register">Register</a></li>
										<li id="list_links"><a href="index.php?op=activities">Activities</a></li>
										<li id="list_links"><a href="index.php?op=program">Program</a></li>
										<li id="list_links"><a href="index.php?op=useful_links">Useful Links</a></li>
										<li id="list_links"><a href="index.php?op=reservations">Reservations</a></li>
										<li id="list_links"><a href="index.php?op=calendar">Calendar</a></li>
										<li id="list_links"><a href="index.php?op=contact_us">Contact Us</a></li>

										<?php
											if($dbarray['custom_pages'] == 1){
												$connecti = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die(mysql_error());
												mysql_select_db(DB_NAME, $connecti) or die(mysql_error());
												$q = "SELECT * FROM pages";
												$result = mysql_query($q, $connecti);
												
												while($row = mysql_fetch_array($result)){
													if($row['is_visible'] == 1){
														?><li id="list_links"><a href='index.php?op=custom_page&page=<?php echo $row['page_id']; ?>'><?php echo $row['page_title']; ?></a></li><?php
													} 
												}
											}
										?>
									</ol>

								</div>
							</div>
							<div id="cont_calendar">
								<div id="cal_title">
									Events
								</div>
								<?php
								$connecte = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die(mysql_error());
								mysql_select_db(DB_NAME, $connecte) or die(mysql_error());
								$q = "SELECT * FROM events";
								$result = mysql_query($q, $connecte);
								?>

								<table>
									<?php
									while($row = mysql_fetch_array($result)){
										echo "<tr><td>".$row['event_title']."</td></tr>";
									}
									?>
								</table>
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<div id="inner_content">
								<div id="container_title">
							        <?php if (!isset($_GET['op']) || $_GET['op'] == ""){echo "Home";}else{echo str_replace('_', ' ', $_GET['op']);}?>
								</div>
								<div id="margin">
									<?php
										if (!isset($_GET['op'])) { 
											include("modules/home.php"); 
										} else {
										  	$op = $_GET['op'];
									      	if (is_file("modules/".$op.".php")) {
									      		include("modules/".$op.".php");
									      	} else {	
												echo ("<div id='error'>Module could not be found!<br/></div>");
									      	}
										} 
									?>
								</div>
							</div>
						</td>
						<td></td>
						<td></td>
					</tr>
				</table>
			</div>
		</div>
		<div id="footer">
			&copy; <?php echo $dbarray['copyright'] ?>
		</div>
	</body>
</html>
