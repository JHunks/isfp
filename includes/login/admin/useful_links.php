<?php
if(isset($_POST['edit_this_link'])){
	//$_POST['edit_site_page'];
	if ($_POST['page_enabled'] == "yes"){
		$vbl = 1;
	} elseif ($_POST['page_enabled'] == "no"){
		$vbl = 0;
	}
	$q = "UPDATE useful_links SET page_title = '".$_POST['page_title']."', page_content = '".$_POST['page_content']."', date_modified = '".date('Y-m-d h:m:s')."', modified_by = '".$session->username."', is_visible = '".$vbl."' WHERE page_id='".$_POST['edit_site_page']."'";
	if(mysql_query($q, $connection_ul)){echo"success";} else {echo"failure";}
}

if(isset($_POST['create_new_link'])){
	if ($_POST['page_enabled'] == "yes"){
		$vbl = 1;
	} elseif ($_POST['page_enabled'] == "no"){
		$vbl = 0;
	}
	$q = "INSERT INTO useful_links SET page_title = '".$_POST['page_title']."', page_content = '".$_POST['page_content']."', date_created = '".date('Y-m-d h:m:s')."', author = '".$session->username."', is_visible = '".$vbl."'";
	if(mysql_query($q, $connection_ul)){echo"success";} else {echo"failure";}
}

if(isset($_POST['delete_this_link'])){
	$q = "DELETE FROM useful_links WHERE link_id=".$_POST['delete_this_link'];
	if(mysql_query($q, $connection_ul)){echo"success";} else {echo"failure";}
}
?>

<table class="edit_data">
	<tr>
		<td>Title</td><td> | </td>
		<td>Description</td><td> | </td>
		<td>URL</td><td> | </td>
		<td>Action</td>
	</tr>
	<?php 
		$connection_ul = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die(mysql_error());
		mysql_select_db(DB_NAME, $connection_ul) or die(mysql_error());
		$q = "SELECT * FROM useful_links";
		$result = mysql_query($q, $connection_ul);
		while($row = mysql_fetch_array($result)){ 
	?>
	<tr>
		<td class="edit_data"><?php echo $row['link_title']; ?></td><td> | </td>
		<td class="edit_data"><?php echo $row['link_description']; ?></td><td> | </td>
		<td class="edit_data"><a href='<?php echo $row['link_url']; ?>' target="_blank"><?php echo $row['link_url']; ?></a></td><td> | </td>
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