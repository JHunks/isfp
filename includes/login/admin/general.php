<?php
if(!$session->isAdmin()){
	die("you should not be here. ip recorded, errors logged.");
}
$connection_gr = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die(mysql_error());
mysql_select_db(DB_NAME, $connection_gr) or die(mysql_error());
$q = "SELECT * FROM settings";
$result = mysql_query($q, $connection_gr);
$dbarray = mysql_fetch_array($result);

if(isset($_POST['edit_site_settings'])){
	if ($_POST['custom_pages'] == "yes"){
		$cpg = 1;
	} elseif ($_POST['custom_pages'] == "no"){
		$cpg = 0;
	}
	if ($_POST['display_calendar'] == "yes"){
		$sdp = 1;
	} elseif ($_POST['display_calendar'] == "no"){
		$sdp = 0;
	}
	$k = "UPDATE settings SET site_title = '".$_POST['s_title']."', site_name = '".$_POST['s_name']."', copyright='".$_POST['s_copyright']."', custom_pages = '".$cpg."', site_email = '".$_POST['s_email']."', site_url = '".$_POST['s_site_url']."', display_calendar = '".$sdp."' WHERE site_id=1";
	if(mysql_query($k, $connection_gr)) {echo"<div id='blue_notification_message_box'>Success, refresh the page for changes to take effect.</div>";}else {echo"<div id='red_notification_message_box'>Failure</div>";}
}

mysql_close($connection_gr);

?>


<form action="" method="post">
	<table class="edit_data" style="border: 1px solid #bdbdbc;">
		<tr>
			<th>General Settings:</th>
		</tr>
		<tr>
			<td style="padding-left: 10px;" width="200">Site title:</td>
			<td><input type="text" name="s_title" value="<?php echo $dbarray['site_title']; ?>" size="40"></td>
		</tr>
		<tr>
			<td style="padding-left: 10px;" >Site name:</td>
			<td><input type="text" name="s_name" value="<?php echo $dbarray['site_name']; ?>" size="40"></td>
		</tr>
		<tr>
			<td style="padding-left: 10px;" >Contact email:</td>
			<td><input type="text" name="s_email" value="<?php echo $dbarray['site_email']; ?>" size="40"></td>
		</tr>
		<tr>
			<td style="padding-left: 10px;" >Show custom pages:</td>
			<td>
				<input type="radio" name="custom_pages" value="yes" <?php if($dbarray['custom_pages'] == 1){echo "checked";}?>>yes
				<input type="radio" name="custom_pages" value="no" <?php if($dbarray['custom_pages'] == 0){echo "checked";}?>>no
			</td>
		</tr>
		<tr>
			<td style="padding-left: 10px;" >Copyright:</td>
			<td><input type="text" name="s_copyright" value="<?php echo $dbarray['copyright']; ?>" size="40" ></td>
		</tr>
		<tr>
			<td style="padding-left: 10px;" >Site URL:</td>
			<td><input type="text" name="s_site_url" value="<?php echo $dbarray['site_url']; ?>" size="40" ></td>
		</tr>
		<tr>
			<td style="padding-left: 10px;" >Display Calendar?:</td>
			<td>
				<input type="radio" name="display_calendar" value="yes" <?php if($dbarray['display_calendar'] == 1){echo "checked";}?>>yes
				<input type="radio" name="display_calendar" value="no" <?php if($dbarray['display_calendar'] == 0){echo "checked";}?>>no
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				<input type="hidden" name="edit_site_settings" value="1">
				<input type="submit" value="Edit">
			</td>
		</tr>
	</table>
</form>


<?php

// Simple PHP Upload Script:  http://coursesweb.net/php-mysql/

$uploadpath = 'assets/carousel/';      // directory to store the uploaded files
$max_size = 2048;          // maximum file size, in KiloBytes
$alwidth = 2500;            // maximum allowed width, in pixels
$alheight = 1000;           // maximum allowed height, in pixels
$allowtype = array('bmp', 'gif', 'jpg', 'jpe', 'png');        // allowed extensions

if(isset($_FILES['fileup']) && strlen($_FILES['fileup']['name']) > 1) {
  $uploadpath = $uploadpath . basename( $_FILES['fileup']['name']);       // gets the file name
  $sepext = explode('.', strtolower($_FILES['fileup']['name']));
  $type = end($sepext);       // gets extension
  list($width, $height) = getimagesize($_FILES['fileup']['tmp_name']);     // gets image width and height
  $err = '';         // to store the errors

  // Checks if the file has allowed type, size, width and height (for images)
  if(!in_array($type, $allowtype)) $err .= '<div id="red_notification_message_box">The file: <b>'. $_FILES['fileup']['name']. '</b> is not of allowed extension type.</div>';
  if($_FILES['fileup']['size'] > $max_size*1000) $err .= '<div id="red_notification_message_box">Maximum file size must be: '. $max_size. ' KB.</div>';
  if(isset($width) && isset($height) && ($width >= $alwidth || $height >= $alheight)) $err .= '<div id="red_notification_message_box">The maximum Width x Height must be: '. $alwidth. ' x '. $alheight.'</div>';

  // If no errors, upload the image, else, output the errors
  if($err == '') {
    if(move_uploaded_file($_FILES['fileup']['tmp_name'], $uploadpath)) { 
      echo "<div id='blue_notification_message_box'>Image Uploaded</div>";
  } else {
    echo  "<div id='red_notification_message_box'>Failure</div>";
  }
} else {
  echo $err;
}

}

if(isset($_POST['deletethispicture']) && $_POST['deletethispicture'] != ""){
	if(unlink( $_POST['deletethispicture'])){
		echo "<div id='blue_notification_message_box'>Image Deleted</div>";
	} else {
		echo "<div id='red_notification_message_box'>Failure</div>";
	}
}
?> 
<table style="text-align:left; width: 100%;">
	<tr>
		<th colspan="100%">Carousel:</th>
	</tr>
	<tr>
		<td colspan="100%" style="padding-left: 10px; font-size: 12px;">
			Carousel Images are below<br/>
			Max file size: 2048kb<br/>
			File type allowed: JPG<br/>
			Recomended Resolution: 960px wide by 400px tall<br/>
			Maximum Resolution: 2500px wide by 1000px tall<br/>
		</td>
	</tr>
	<tr>
		<td height="20" colspan="100%">
		</td>
	</tr>
	<?php
		$directory = "assets/carousel/";
		$images = glob($directory . "*.jpg");
		foreach($images as $image){
			echo "<tr><td style='padding-left:10px;padding-top: 10px; border-bottom: 1px solid #bdbdbc;'><img src='".$image."' width='100'></td><td style='text-align: right; padding-left: 10px; border-bottom: 1px solid #bdbdbc;'>

			<form action='' method='POST'>
				<input type='hidden' name='deletethispicture' value='$image'>
				<input type='submit' name='submit' value='Delete'>
			</form>

			</td></tr>";
		}
	?>
	<tr>
		<td height="20" colspan="100%">
		</td>
	</tr>
	<tr>
		<td colspan="100%" style="text-align: center;">
			 <form action="" method="POST" enctype="multipart/form-data"> 
			  Add Picture: <input type="file" name="fileup" />
			  <input type="submit" name='submit' value="Upload" /> 
			 </form>
		</td>
	</tr>
</table>