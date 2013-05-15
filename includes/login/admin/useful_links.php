<?php
$connection_ul = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die(mysql_error());
mysql_select_db(DB_NAME, $connection_ul) or die(mysql_error());

if(isset($_POST['edit_this_link'])){
	$l_title = str_replace("'", "\'", $_POST['link_title']);
	$l_desc = str_replace("'", "\'", $_POST['link_description']);
	$l_url = str_replace("'", "\'", $_POST['link_url']);

	$q = "UPDATE useful_links SET link_title = '".$l_title."', link_description = '".$l_desc."', link_url = '".$l_url."' WHERE link_id='".$_POST['edit_this_link']."'";
	if(mysql_query($q, $connection_ul)){echo"<div id='blue_notification_message_box'>Success</div>";} else {echo"<div id='red_notification_message_box'>Failure</div>";}
}

if(isset($_POST['create_new_link'])){
	$l_title = str_replace("'", "\'", $_POST['link_title']);
	$l_desc = str_replace("'", "\'", $_POST['link_description']);
	$l_url = str_replace("'", "\'", $_POST['link_url']);

	$q = "INSERT INTO useful_links SET link_title = '".$l_title."', link_description = '".$l_desc ."', link_url = '".$l_url."'";
	if(mysql_query($q, $connection_ul)){echo"<div id='blue_notification_message_box'>Success</div>";} else {echo"<div id='red_notification_message_box'>Failure</div>";}
}

if(isset($_POST['delete_this_link'])){
	$q = "DELETE FROM useful_links WHERE link_id=".$_POST['delete_this_link'];
	if(mysql_query($q, $connection_ul)){echo"<div id='blue_notification_message_box'>Success</div>";} else {echo"<div id='red_notification_message_box'>Failure</div>";}
}
?>

<table>
	<tr>
		<td>Title</td><td> | </td>
		<td>Description</td><td> | </td>
		<td>URL</td><td> | </td>
		<td width="105">Action</td>
	</tr>
	<?php 
		$connection_ul = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die(mysql_error());
		mysql_select_db(DB_NAME, $connection_ul) or die(mysql_error());
		$q = "SELECT * FROM useful_links";
		$result = mysql_query($q, $connection_ul);
		while($row = mysql_fetch_array($result)){ 
	?>
	<tr>
		<td class="edit_data" style="text-align: left;"><?php echo $row['link_title']; ?></td><td> | </td>
		<td class="edit_data" style="text-align: left; padding-left: 5px; font-size: 10px;"><?php echo $row['link_description']; ?></td><td> | </td>
		<td class="edit_data" style="text-align: left; padding-left: 5px;"><a href='<?php echo $row['link_url']; ?>' target="_blank"><?php echo $row['link_url']; ?></a></td><td> | </td>
		<td class="edit_data">
			<form action="" method="post">
				<input type="hidden" name="edit_link" value='<?php echo $row['link_id']; ?>'>
				<input type="submit" value="Edit">
			</form>
			<form action="" method="post">
				<input type="hidden" name="delete_this_link" value='<?php echo $row['link_id']; ?>'>
				<input type="submit" value="Delete">
			</form>
		</td>
	</tr>
	<?php } 
	mysql_close($connection_ul);?>
	<tr>
		<td colspan="100%">
			<form action="" method="post">
				<input type="hidden" name="create_link" value="1">
				<input type="submit" value="Create a Link">
			</form>
		</td>
	</tr>
</table><br/>

<?php
if(isset($_POST['edit_link'])){
	$l_id = $_POST['edit_link'];
	$connection_pg = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die(mysql_error());
	mysql_select_db(DB_NAME, $connection_pg) or die(mysql_error());
	$q = "SELECT * FROM useful_links WHERE link_id='".$l_id."'";
	$result = mysql_query($q, $connection_pg);
	$row = mysql_fetch_array($result)
?>
<form action="" method="post">
	<table>
		<tr>
			<td class="edit_data">Title: </td>
			<td class="edit_data"><input type="text" name="link_title" value="<?php echo $row['link_title']; ?>"></td>
		</tr>
		<tr>
			<td class="edit_data">Description: </td>
			<td class="edit_data"><input type="text" name="link_description" value="<?php echo $row['link_description']; ?>"></td>
		</tr>
		<tr>
			<td class="edit_data">URL: </td>
			<td class="edit_data"><input type="text" name="link_url" value="<?php echo $row['link_url']; ?>"></td>
		</tr>
		<tr>
			<td colspan="100%">
				<input type="hidden" name="edit_this_link" value='1'>
				<input type="submit" value="Save">
			</td>
		</tr>
	</table>
</form>
<?php } 

if(isset($_POST['create_link'])){
?>
<form action="" method="post">
	<table align="center">
		<tr>
			<td class="edit_data">Title: </td>
			<td class="edit_data"><input type="text" name="link_title" placeholder="title"></td>
		</tr>
		<tr>
			<td class="edit_data">Description: </td>
			<td class="edit_data"><input type="text" name="link_description" placeholder="description"></td>
		</tr>
		<tr>
			<td class="edit_data">URL: </td>
			<td class="edit_data"><input type="text" name="link_url" placeholder="url starting with http://"></td>
		</tr>
		<tr>
			<td colspan="100%">
				<input type="hidden" name="create_new_link" value="1">
				<input type="submit" value="Create">
			</td>
		</tr>
	</table>
</form>
<?php } ?>