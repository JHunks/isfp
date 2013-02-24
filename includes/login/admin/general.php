<?php
   
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
	$k = "UPDATE settings SET site_title = '".$_POST['s_title']."', site_name = '".$_POST['s_name']."', copyright='".$_POST['s_copyright']."', custom_pages = '".$cpg."' WHERE site_id=1";
	if(mysql_query($k, $connection_gr)) {echo"success";}else {echo"failure";}
}

mysql_close($connection_gr);
?>
<form action="" method="post">
	<table class="edit_data">
		<tr>
			<td>Site title:</td>
			<td><input type="text" name="s_title" value="<?php echo $dbarray['site_title']; ?>"></td>
		</tr>
		<tr>
			<td>Site name:</td>
			<td><input type="text" name="s_name" value="<?php echo $dbarray['site_name']; ?>"></td>
		</tr>
		<tr>
			<td>Show custom pages:</td>
			<td>
				<input type="radio" name="custom_pages" value="yes" <?php if($dbarray['custom_pages'] == 1){echo "checked";}?>>yes
				<input type="radio" name="custom_pages" value="no" <?php if($dbarray['custom_pages'] == 0){echo "checked";}?>>no
			</td>
		</tr>
		<tr>
			<td>Copyright:</td>
			<td><input type="text" name="s_copyright" value="<?php echo $dbarray['copyright']; ?>"></td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="hidden" name="edit_site_settings" value="1">
				<input type="submit" value="Edit">
			</td>
		</tr>
	</table>
</form>