<?php
if(!$session->logged_in){
	die("<div id='red_notification_message_box'>you should not be here. ip recorded, errors logged.</div>");
}

$connection = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die(mysql_error());
mysql_select_db(DB_NAME, $connection) or die(mysql_error());

$q = "SELECT * FROM registered_to_event WHERE user_id = '".$session->username."'";
$result = mysql_query($q, $connection);
?>
<table style="width: 680px; margin: 10px; text-align: left; border: 1px solid grey;">
	<tr>
		<th colspan="100%">
			Events you are attending:	
		</th>
	</tr>
	<tr>
		<td style="width: 50px; padding-left: 5px;">#</td>
		<td>Name</td>
		<td>Date start</td>
		<td>Time start</td>
		<td>Items</td>
		<td>Guests</td>
		<td>Action</td>
	</tr>
	<tr>
		<td colspan="100%"><hr/></td>
	</tr>
<?php
$i = 1;
while($info_r = mysql_fetch_array($result)){
	$q2 = "SELECT * FROM events WHERE event_id =".$info_r['event_id'];
	$result2 = mysql_query($q2, $connection);
	$info_e = mysql_fetch_array($result2);
	?>
	<tr>
		<td style="width: 50px; padding-left: 5px;"><?php echo $i; ?></td>
		<td><?php echo $info_e['event_title']; ?></td>
		<td><?php echo "[".$info_e['start_time']."]"; ?></td>
		<td><?php echo $info_e['start_hour']; ?></td>
		<td><?php echo $info_r['bring_item_amount']; ?></td>
		<td><?php echo $info_r['bring_num_guests']; ?></td>
	</tr>
	<?php
$i++;
}
?>
</table>