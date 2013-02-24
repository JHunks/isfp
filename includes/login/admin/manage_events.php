<?php
   
$connection_ev = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die(mysql_error());
mysql_select_db(DB_NAME, $connection_ev) or die(mysql_error());
$q = "SELECT * FROM pages";
$result = mysql_query($q, $connection_ev);

if(isset($_POST['edit_this_event'])){
	$q = "UPDATE events SET event_title = '".$_POST['event_title']."', event_host = '".$_POST['event_host']."', event_location = '".$_POST['event_location']."', start_time = '".$_POST['start_time']."', end_time = '".$_POST['end_time']."', guest_list = '".$_POST['guest_list']."',enterance_fee = '".$_POST['enterance_fee']."', event_description = '".$_POST['event_description']."' WHERE event_id='".$_POST['edit_this_event']."'";
	if(mysql_query($q, $connection_ev)){echo"success";} else {echo"failure";}
}

if(isset($_POST['create_new_event'])){
	$q = "INSERT INTO events SET event_title = '".$_POST['event_title']."', event_host = '".$_POST['event_host']."', event_location = '".$_POST['event_location']."', start_time = '".$_POST['start_time']."', end_time = '".$_POST['end_time']."', guest_list = '".$_POST['guest_list']."',enterance_fee = '".$_POST['enterance_fee']."', event_description = '".$_POST['event_description']."'";
	if(mysql_query($q, $connection_ev)){echo"success";} else {echo"failure";}
}

if(isset($_POST['delete_this_event'])){
	$q = "DELETE FROM events WHERE event_id=".$_POST['delete_this_event'];
	if(mysql_query($q, $connection_ev)){echo"success";} else {echo"failure";}
}

mysql_close($connection_ev);
?>

<table class="edit_data">
	<tr>
		<td>Title</td><td> | </td>
		<td>Host</td><td> | </td>
		<td>Location</td><td> | </td>
		<td>Start Time</td><td> | </td>
		<td>End Time</td><td> | </td>
		<td width="105">Action</td>
	</tr>
		<?php 
			$connection_ev = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die(mysql_error());
			mysql_select_db(DB_NAME, $connection_ev) or die(mysql_error());
			$q = "SELECT * FROM events";
			$result = mysql_query($q, $connection_ev);
			while($row = mysql_fetch_array($result)){ 
		?>
	<tr>
		<td class="edit_data"><?php echo $row['event_title']; ?></td><td> | </td>
		<td class="edit_data"><?php echo $row['event_host']; ?></td><td> | </td>
		<td class="edit_data"><?php echo $row['event_location']; ?></td><td> | </td>
		<td class="edit_data"><?php echo $row['start_time']; ?></td><td> | </td>
		<td class="edit_data"><?php echo $row['end_time']; ?></td><td> | </td>
		<td class="edit_data">
			<form action="" method="post">
				<input type="hidden" name="edit_event" value='<?php echo $row['event_id']; ?>'>
				<input type="submit" value="Edit">
			</form>
			<form action="" method="post">
				<input type="hidden" name="delete_this_event" value='<?php echo $row['event_id']; ?>'>
				<input type="submit" value="Delete">
			</form>
		</td>
	</tr>
	<?php } 
	mysql_close($connection_ev);?>
	<tr>
		<td colspan="100%">
			<form action="" method="post">
				<input type="hidden" name="create_event" value="1">
				<input type="submit" value="Create an Event">
			</form>
		</td>
	</tr>
</table><br/>

<?php
if(isset($_POST['edit_event'])){
	$e_id = $_POST['edit_event'];
	$connection_ev = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die(mysql_error());
	mysql_select_db(DB_NAME, $connection_ev) or die(mysql_error());
	$q = "SELECT * FROM events WHERE event_id='".$e_id."'";
	$result = mysql_query($q, $connection_ev);
	$row = mysql_fetch_array($result)
?>
<form action="" method="post">
	<table class="edit_data">
		<tr>
			<td>Title:</td>
			<td><input type="text" name="event_title" value="<?php echo $row['event_title']; ?>"></td>
		</tr>
		<tr>
			<td>Description:</td>
			<td>
				<textarea name="event_description"><?php echo $row['event_description']; ?></textarea>
			</td>
		</tr>
		<tr>
			<td>Hosted by:</td>
			<td><input type="text" name="event_host" value="<?php echo $row['event_host']; ?>">At location: <input type="text" name="event_location" value="<?php echo $row['event_location']; ?>"></td>
		</tr>
		<tr>
			<td>Starts at:</td>
			<td><input type="text" name="start_time" value="<?php echo $row['start_time']; ?>">Ends at: <input type="text" name="end_time" value="<?php echo $row['end_time']; ?>"></td>
		</tr>
		<tr>
			<td>Guests:</td>
			<td>
				<textarea name="guest_list"><?php echo $row['guest_list']; ?></textarea>
			</td>
		</tr>
		<tr>
			<td>Enterance fee:</td>
			<td><input type="text" name="enterance_fee" value="<?php echo $row['enterance_fee']; ?>"></td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="hidden" name="edit_this_event" value='<?php echo $e_id; ?>'>
				<input type="submit" value="Save">
			</td>
		</tr>
	</table>
</form>
<?php } 

if(isset($_POST['create_event'])){
?>
<form action="" method="post">
	<table class="edit_data">
		<tr>
			<td>Title:</td>
			<td><input type="text" name="event_title" placeholder="title"></td>
		</tr>
		<tr>
			<td>Description:</td>
			<td>
				<textarea name="event_description" placeholder="description"></textarea>
			</td>
		</tr>
		<tr>
			<td>Hosted by:</td>
			<td><input type="text" name="event_host" placeholder="person">At location: <input type="text" name="event_location" placeholder="place"></td>
		</tr>
		<tr>
			<td>Starts at:</td>
			<td><input type="text" name="start_time">Ends at: <input type="text" name="end_time"></td>
		</tr>
		<tr>
			<td>Guests:</td>
			<td>
				<textarea name="guest_list"></textarea>
			</td>
		</tr>
		<tr>
			<td>Enterance fee:</td>
			<td><input type="text" name="enterance_fee" placeholder="$2.00"></td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="hidden" name="create_new_event" value="1">
				<input type="submit" value="Create">
			</td>
		</tr>
	</table>
</form>
<?php } ?>