
<script type="text/javascript" src="includes/jquery.timepicker.js"></script>
<link rel="stylesheet" type="text/css" href="assets/css/jquery.timepicker.css" />
<script type="text/javascript" src="includes/base.js"></script>
<link rel="stylesheet" type="text/css" href="assets/css/base.css" />

<?php
if(!$session->isAdmin()){
	die("you should not be here. ip recorded, errors logged.");
}
$connection_ev = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die(mysql_error());
mysql_select_db(DB_NAME, $connection_ev) or die(mysql_error());
$q = "SELECT * FROM pages";
$result = mysql_query($q, $connection_ev);

if(isset($_POST['edit_this_event'])){
	$e_title = str_replace("'", "\'", $_POST['event_title']);
	$e_host = str_replace("'", "\'", $_POST['event_host']);
	$e_location = str_replace("'", "\'", $_POST['event_location']);
	$s_time = str_replace("'", "\'", $_POST['start_time']);
	$e_time = str_replace("'", "\'", $_POST['end_time']);
	$e_fee = str_replace("'", "\'", $_POST['enterance_fee']);
	$e_description = str_replace("'", "\'", $_POST['event_description']);
	$errrrrrrur = false;

	$g = "DELETE FROM bring_to_event WHERE event_id = '".$_POST['edit_this_event']."'";
	if(mysql_query($g, $connection_ev)){$errrrrrrur = false;} else {$errrrrrrur = true;}
	
	//echo "number of items to bring: ".$_POST['num_of_items_to_bring'];

	for($i = 1; $i <= $_POST['num_of_items_to_bring']; $i++){
		//echo $_POST['edit_this_item_'.strval($i)]."<br/>";
		if(isset($_POST['edit_this_item_'.strval($i)])){
			//echo "<br/>bring item: ";
			//echo $_POST['edit_this_item_'.strval($i)];
			//echo " | amount: ";
			//echo $_POST['edit_this_item_amount_'.strval($i)];
			$i_to_bring = str_replace("'", "\'", $_POST['edit_this_item_'.strval($i)]);
			$i_quantity = str_replace("'", "\'", $_POST['edit_this_item_amount_'.strval($i)]);
			$q = "INSERT INTO bring_to_event SET randomPK = 0, event_id='".$_POST['edit_this_event']."', item_name = '".$i_to_bring."', quantity = '".$i_quantity."'";
			if(mysql_query($q, $connection_ev)){$errrrrrrur = false;} else {$errrrrrrur = true;}
		}
	}

	$z = "UPDATE events SET event_title = '".$e_title."', event_host = '".$e_host."', event_location = '".$e_location."', start_time = '".$s_time."', end_time = '".$e_time."',enterance_fee = '".$e_fee."', event_description = '".$e_description."', start_hour = '".$_POST['start_hour']."', end_hour = '".$_POST['end_hour']."' WHERE event_id='".$_POST['edit_this_event']."'";
	if(mysql_query($z, $connection_ev)){$errrrrrrur = false;} else {$errrrrrrur = true;}
	if(!$errrrrrrur){echo"<div id='blue_notification_message_box'>Success</div>";} else {echo"<div id='red_notification_message_box'>Failure</div>";}
}

if(isset($_POST['create_new_event'])){
	$e_title = str_replace("'", "\'", $_POST['event_title']);
	$e_host = str_replace("'", "\'", $_POST['event_host']);
	$e_location = str_replace("'", "\'", $_POST['event_location']);
	$s_time = str_replace("'", "\'", $_POST['start_time']);
	$e_time = str_replace("'", "\'", $_POST['end_time']);
	$e_fee = str_replace("'", "\'", $_POST['enterance_fee']);
	$e_description = str_replace("'", "\'", $_POST['event_description']);

/*
	echo "<br/>items to bring: ";
	echo $_POST['num_of_items_to_bring'];
	$c = "bring_this_item_";
	$c = $c.strval(1);
	echo "<br/>selecting index: ";
	echo $c;
	echo "<br/>displaying value of index: ";
	echo $_POST[$c];
*/
	$errrrrrrur = false;

	$q = "INSERT INTO events SET event_id = 0, event_title = '".$e_title."', event_host = '".$e_host."', event_location = '".$e_location."', start_time = '".$s_time."', end_time = '".$e_time."',enterance_fee = '".$e_fee."', event_description = '".$e_description."', start_hour = '".$_POST['start_hour']."', end_hour = '".$_POST['end_hour']."'";
	if(mysql_query($q, $connection_ev)){$errrrrrrur = false;} else {$errrrrrrur = true;}

	$q = "SELECT event_id FROM events WHERE event_title ='".$e_title."'";
	
	$resultttt = mysql_query($q,$connection_ev);
	$event_id_selector = mysql_fetch_array($resultttt);
	//echo "<br/>this event id is: ";
	//echo $event_id_selector['event_id'];
	
	for($i = 1; $i <= $_POST['num_of_items_to_bring']; $i++){
		if(isset($_POST['bring_this_item_'.strval($i)])){
			//echo "<br/>bring item: ";
			//echo $_POST['bring_this_item_'.strval($i)];
			//echo " | amount: ";
			//echo $_POST['bring_this_item_amount_'.strval($i)];
			$i_to_bring = str_replace("'", "\'", $_POST['bring_this_item_'.strval($i)]);
			$i_quantity = str_replace("'", "\'", $_POST['bring_this_item_amount_'.strval($i)]);
			$q = "INSERT INTO bring_to_event SET randomPK = 0, event_id='".$event_id_selector['event_id']."', item_name = '".$i_to_bring."', quantity = '".$i_quantity."'";
			if(mysql_query($q, $connection_ev)){$errrrrrrur = false;} else {$errrrrrrur = true;}
		}
	}

	if(!$errrrrrrur){echo"<div id='blue_notification_message_box'>Success</div>";} else {echo"<div id='red_notification_message_box'>Failure</div>";}
	
}

if(isset($_POST['delete_this_event'])){
	$errruurrr = false;

	$q = "DELETE FROM events WHERE event_id=".$_POST['delete_this_event'];
	if(mysql_query($q, $connection_ev)){$errruurrr = false;}else{$errruurrr = true;}
	$z = "DELETE FROM registered_to_event WHERE event_id=".$_POST['delete_this_event'];
	if(mysql_query($z, $connection_ev)){$errruurrr = false;}else{$errruurrr = true;}
	$x = "DELETE FROM registered_to_event_buffer WHERE event_id=".$_POST['delete_this_event'];
	if(mysql_query($x, $connection_ev)){$errruurrr = false;}else{$errruurrr = true;}
	$y = "DELETE FROM bring_to_event WHERE event_id=".$_POST['delete_this_event'];
	if(mysql_query($y, $connection_ev)){$errruurrr = false;}else{$errruurrr = true;}
	
	if(!$errruurrr){echo"<div id='blue_notification_message_box'>Success</div>";} else {echo"<div id='red_notification_message_box'>Failure</div>";}
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
	$row = mysql_fetch_array($result);

	$w = "SELECT * FROM bring_to_event WHERE event_id='".$e_id."'";
	$resul = mysql_query($w, $connection_ev);
?>
<form action="" method="post">
	<table class="edit_data">
		<tr>
			<td>Title:</td>
			<td colspan="2"><input type="text" name="event_title" value="<?php echo $row['event_title']; ?>"></td>
		</tr>
		<tr>
			<td>Description:</td>
			<td colspan="2">
				<textarea name="event_description" cols="60" rows="10"><?php echo $row['event_description']; ?></textarea>
			</td>
		</tr>
		<tr>
			<td>Hosted by:</td>
			<td colspan="2">
				<input type="text" name="event_host" value="<?php echo $row['event_host']; ?>">
			</td>
		</tr>
		<tr>
			<td>At location: </td>
			<td colspan="2"><input type="text" name="event_location" value="<?php echo $row['event_location']; ?>"></td>
		</tr>
		<tr>
			<td>Time:</td>
			<td>
				<script src="includes/datepair.js"></script>
				<div class="example">
					<p class="datepair" data-language="javascript">
						<input size="10" type="text" class="date start" name="start_time" value="<?php echo $row['start_time']; ?>"/>
						<input size="10" type="text" id="start_hour" name="start_hour" class="time start" value="<?php echo $row['start_hour']; ?>"/> to
						<input size="10" type="text" id="end_hour" name="end_hour" class="time end" value="<?php echo $row['end_hour']; ?>"/>
						<input size="10" type="text" class="date end" name="end_time" value="<?php echo $row['end_time']; ?>"/>
					</p>
				</div>
			</td>
		</tr>
		<tr>
			<td>Enterance fee:</td>
			<td colspan="2"><input type="text" name="enterance_fee" value="<?php echo $row['enterance_fee']; ?>"></td>
		</tr>
		<tr>
			<td>Bring Items:</td>
			<td>
				<script language="JavaScript">
					var kriaaaa = <?php echo mysql_num_rows($resul)+1;?>;
					function add(){
					    $('#inputList').append('<div id="item_'+ kriaaaa +'"><input placeholder="item #'+kriaaaa+'" name="edit_this_item_'+kriaaaa+'" type="text"/><input type="text" size="4" placeholder="amount" name="edit_this_item_amount_'+kriaaaa+'"/><input type="image" src="assets/images/minus-button-md.png" onclick="rem('+kriaaaa+')"/></div>');
					    $('#num_of_items_to_bring').val(kriaaaa);
					    kriaaaa++;
					}
					function rem(kk){
					    $('#item_'+kk).remove();
					}
				</script>
				<div id="inputList">
					<?php
					$kria = 1; 
						while($bring = mysql_fetch_array($resul)){
							echo '<div id="item_'.strval($kria).'"><input value="'.$bring['item_name'].'" name="edit_this_item_'.strval($kria).'" type="text"/><input type="text" size="4" value="'.$bring['quantity'].'" name="edit_this_item_amount_'.strval($kria).'"/><input type="image" src="assets/images/minus-button-md.png" onclick="rem('.strval($kria).')"/></div>';
							$kria++;
						}
					?>
					<input type="hidden" id="num_of_items_to_bring" name="num_of_items_to_bring" value="<?php echo mysql_num_rows($resul)+1;?>">
				</div>
				<img type="button" src="assets/images/button_add_01.png" onclick="add()">
			</td>
		</tr>
		<tr>
			<td colspan="4">
				<input type="hidden" name="edit_this_event" value='<?php echo $e_id; ?>'>
				<input type="submit" value="Save">
			</td>
		</tr>
	</table>
</form>
<div style="text-align: left;">
<form action="includes/generate_report.php" method="post">
	<input type="hidden" name="generate_a_report" value='<?php echo $e_id; ?>'>
	<input type="submit" value="Generate Report">
</form>
</div>
<?php } 

if(isset($_POST['create_event'])){
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
				<textarea name="event_description" cols="60" rows="10"><?php echo $row['event_description']; ?></textarea>
			</td>
		</tr>
		<tr>
			<td>Hosted by:</td>
			<td>
				<input type="text" name="event_host" value="<?php echo $row['event_host']; ?>">
			</td>
		</tr>
		<tr>
			<td>At location: </td>
			<td><input type="text" name="event_location" value="<?php echo $row['event_location']; ?>"></td>
		</tr>
		<tr>
			<td>Time:</td>
			<td>
				<script src="includes/datepair.js"></script>
				<p class="datepair" data-language="javascript">
					<input size="10" type="text" class="date start" name="start_time" value="<?php echo $row['start_time']; ?>"/>
					<input size="10" type="text" name="start_hour" class="time start" value="<?php echo $row['start_hour']; ?>"/> to
					<input size="10" type="text" name="end_hour" class="time end" value="<?php echo $row['end_hour']; ?>"/>
					<input size="10" type="text" class="date end" name="end_time" value="<?php echo $row['end_time']; ?>"/>
				</p>
			</td>
		</tr>
		<tr>
			<td>Enterance fee:</td>
			<td><input type="text" name="enterance_fee" value="<?php echo $row['enterance_fee']; ?>"></td>
		</tr>
		<tr>
			<td>Bring Items:</td>
			<td>
				<script language="JavaScript">
					var kriaaaa = 1;
					function add(){
					    $('#inputList').append('<div id="item_'+ kriaaaa +'"><input placeholder="item #'+kriaaaa+'" name="bring_this_item_'+kriaaaa+'" type="text"/><input type="text" size="4" placeholder="amount" name="bring_this_item_amount_'+kriaaaa+'"/><input type="image" src="assets/images/minus-button-md.png" onclick="rem('+kriaaaa+')"/></div>');
					    $('#num_of_items_to_bring').val(kriaaaa);
					    kriaaaa++;
					}
					function rem(kk){
					    $('#item_'+kk).remove();
					}
				</script>
				<div id="inputList">
					<input type="hidden" id="num_of_items_to_bring" name="num_of_items_to_bring" value="0">
				</div>
				<img type="button" src="assets/images/button_add_01.png" onclick="add()">
			</td>
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