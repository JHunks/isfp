<?php
if(!$session->isAdmin()){
	die("<div id='red_notification_message_box'>you should not be here. ip recorded, errors logged.</div>");
} 
$connection_pg = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die(mysql_error());
mysql_select_db(DB_NAME, $connection_pg) or die(mysql_error());
$q = "SELECT * FROM pages";
$result = mysql_query($q, $connection_pg);

if(isset($_POST['edit_site_page'])){
	//$_POST['edit_site_page'];
	if ($_POST['page_enabled'] == "yes"){
		$vbl = 1;
	} elseif ($_POST['page_enabled'] == "no"){
		$vbl = 0;
	}

	$p_title = str_replace("'", "\'", $_POST['page_title']);
	$p_content = str_replace("'", "\'", $_POST['page_content']);

	$q = "UPDATE pages SET page_title = '".$p_title."', page_content = '".$p_content."', date_modified = '".date('Y-m-d h:m:s')."', modified_by = '".$session->username."', is_visible = '".$vbl."' WHERE page_id='".$_POST['edit_site_page']."'";
	if(mysql_query($q, $connection_pg)){echo"<div id='blue_notification_message_box'>Success</div>";} else {echo"<div id='red_notification_message_box'>Failure</div>";}
}

if(isset($_POST['add_site_page'])){
	if ($_POST['page_enabled'] == "yes"){
		$vbl = 1;
	} elseif ($_POST['page_enabled'] == "no"){
		$vbl = 0;
	}

	$p_title = str_replace("'", "\'", $_POST['page_title']);
	$p_content = str_replace("'", "\'", $_POST['page_content']);

	$q = "INSERT INTO pages SET page_title = '".$p_title."', page_content = '".$p_content."', date_created = '".date('Y-m-d h:m:s')."', author = '".$session->username."', is_visible = '".$vbl."'";
	if(mysql_query($q, $connection_pg)){echo"<div id='blue_notification_message_box'>Success</div>";} else {echo"<div id='red_notification_message_box'>Failure</div>";}
}

if(isset($_POST['delete_this_page'])){
	$q = "DELETE FROM pages WHERE page_id=".$_POST['delete_this_page'];
	if(mysql_query($q, $connection_pg)){echo"<div id='blue_notification_message_box'>Success</div>";} else {echo"<div id='red_notification_message_box'>Failure</div>";}
}

mysql_close($connection_pg);
?>


<table class="edit_data">
	<tr>
		<td>Title</td><td> | </td>
		<td>Author</td><td> | </td>
		<td>Date Created</td><td> | </td>
		<td>Date Modified</td><td> | </td>
		<td>Modified By</td><td> | </td>
		<td width="105">Action</td>
	</tr>
	<?php 
		$connection_pg = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die(mysql_error());
		mysql_select_db(DB_NAME, $connection_pg) or die(mysql_error());
		$q = "SELECT * FROM pages";
		$result = mysql_query($q, $connection_pg);
		while($row = mysql_fetch_array($result)){ ?>
	<tr>
		<td class="edit_data"><?php echo $row['page_title']; ?></td><td> | </td>
		<td class="edit_data"><?php echo $row['author']; ?></td><td> | </td>
		<td class="edit_data"><?php echo $row['date_created']; ?></td><td> | </td>
		<td class="edit_data">
			<?php 
				if(isset($row['date_modified'])){ 
					echo $row['date_modified']; 
				} else { 
					echo "<div id='error'>never modified</div>";
				}
			?>
		</td><td> | </td>
		<td class="edit_data">
			<?php 
				if(isset($row['modified_by'])){ 
					echo $row['modified_by']; 
				} else { 
					echo "<div id='error'>no one</div>";
				}
			?>

		</td><td> | </td>
		<td class="edit_data">
			<form action="" method="post">
				<input type="hidden" name="edit_this_page" value='<?php echo $row['page_id']; ?>'>
				<input type="submit" value="Edit">
			</form>
			<form action="" method="post">
				<input type="hidden" name="delete_this_page" value='<?php echo $row['page_id']; ?>'>
				<input type="submit" value="Delete">
			</form>
		</td>
	</tr>
	<?php } 
	mysql_close($connection_pg);?>
	<tr>
		<td colspan="100%">
			<form action="" method="post">
				<input type="hidden" name="create_new_page" value="1">
				<input type="submit" value="Create a Page">
			</form>
		</td>
	</tr>
</table><br/>

<?php
if(isset($_POST['edit_this_page'])){
	$p_id = $_POST['edit_this_page'];
	$connection_pg = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die(mysql_error());
	mysql_select_db(DB_NAME, $connection_pg) or die(mysql_error());
	$q = "SELECT * FROM pages WHERE page_id='".$p_id."'";
	$result = mysql_query($q, $connection_pg);
	$row = mysql_fetch_array($result)
?>
<form action="" method="post">
	<table class="edit_data">
		<tr>
			<td>Title:</td>
			<td><input type="text" name="page_title" value="<?php echo $row['page_title']; ?>"></td>
		</tr>
		<tr>
			<td>Content:</td>
			<td>
				<textarea name="page_content"><?php echo $row['page_content']; ?></textarea>
				<script>CKEDITOR.replace('page_content');</script>
			</td>
		</tr>
		<tr>
			<td>Created On:</td>
			<td><input type="text" name="page_date_created" disabled value="<?php echo $row['date_created']; ?>">By: <input type="text" name="page_author" disabled value="<?php echo $row['author']; ?>"></td>
		</tr>
		<tr>
			<td>Modified On:</td>
			<td>
				<?php if(isset($row['date_modified'])){ ?>
					<input type="text" disabled name="page_date_modified" value="<?php echo $row['date_modified']; ?>">By: <input type="text" name="modified_by" disabled value="<?php echo $row['modified_by']; ?>">
				<?php } else { ?>
					never modified
				<?php } ?>
			</td>
		</tr>
		<tr>
			<td>Enabled?</td>
			<td>
				<input type="radio" name="page_enabled" value="yes" <?php if($row['is_visible'] == 1){echo "checked";}?>>yes
				<input type="radio" name="page_enabled" value="no" <?php if($row['is_visible'] == 0){echo "checked";}?>>no
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="hidden" name="edit_site_page" value='<?php echo $p_id; ?>'>
				<input type="submit" value="Save">
			</td>
		</tr>
	</table>
</form>
<?php } 

if(isset($_POST['create_new_page'])){
?>
<form action="" method="post">
	<table class="edit_data">
		<tr>
			<td>Title:</td>
			<td><input type="text" name="page_title" placeholder="title here"></td>
		</tr>
		<tr>
			<td>Content:</td>
			<td>
				<textarea name="page_content"></textarea>
				<script>CKEDITOR.replace('page_content');</script>
			</td>
		</tr>
		<tr>
			<td>Created On:</td>
			<td><input type="text" name="page_date_created" disabled value="<?php echo date('Y-m-d h:m:s'); ?>">By: <input type="text" disabled name="page_author" value="<?php echo $session->username; ?>"></td>
		</tr>
		<tr>
			<td>Enabled?</td>
			<td>
				<input type="radio" name="page_enabled" value="yes">yes
				<input type="radio" name="page_enabled" value="no" checked>no
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="hidden" name="add_site_page" value="1">
				<input type="submit" value="Create">
			</td>
		</tr>
	</table>
</form>
<?php } ?>