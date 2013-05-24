<?php
if(!$session->logged_in){
	die("<div id='red_notification_message_box'>you should not be here. ip recorded, errors logged.</div>");
}
$connection = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die(mysql_error());
mysql_select_db(DB_NAME, $connection) or die(mysql_error());


if(isset($_POST['unattend_from_event'])){
	$s = "select randomPK from registered_to_event where user_id ='".$session->username."' and event_id ='".$_POST['unattend_from_event']."'";
	$my_event_pk = mysql_fetch_array(mysql_query($s, $connection));
	$q = "delete from registered_to_event where randomPK =".$my_event_pk['randomPK'];
	if(mysql_query($q, $connection)){echo"<div id='blue_notification_message_box'>Your reservation for this event has been removed</div>";}else {echo"<div id='red_notification_message_box'>ERROR - Action Terminated</div>";}

}
if(isset($_POST['edit_reservation_data_for_event_now'])){
	echo "<div id='red_notification_message_box'>This action is still under construction. Please stand by.</div>";



}

$q = "SELECT * FROM registered_to_event WHERE user_id = '".$session->username."'";
$result = mysql_query($q, $connection);
if(mysql_num_rows($result) > 0){
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
		<td>
			<a href="index.php?op=calendar&id=<?php echo $info_e['event_id']; ?>">
				<?php echo $info_e['event_title']; ?>
			</a>
		</td>
		<td><?php echo "[".$info_e['start_time']."]"; ?></td>
		<td><?php echo $info_e['start_hour']; ?></td>
		<td><?php 
				if($info_r['bring_item_amount'] != null && $info_r['bring_item_amount'] != 0){
					$p = "SELECT item_name FROM bring_to_event WHERE randomPK =".$info_r['bring_item_PK'];
					$raz = mysql_query($p, $connection);
					$answaaa = mysql_fetch_array($raz);
					echo $info_r['bring_item_amount']." x ".$answaaa['item_name'];
				} else {
					echo "<div style='font-size: 12px; padding-top: 7px;'>none</div>";
				}
			?>
		</td>
		<td><?php if($info_r['bring_num_guests'] == 0 || $info_r['bring_num_guests'] == null){echo "<div style='font-size: 12px; padding-top: 7px;'>none</div>";}else{echo $info_r['bring_num_guests']; }?></td>
		<td style="width: 180px;">
			<form action="" method="post">
				<input type="hidden" name="edit_reservation_data_for_event" value='<?php echo $info_e['event_id']; ?>'>
				<input type="submit" value="Edit">
			</form>
			<form action="" method="post">
				<input type="hidden" name="unattend_from_event" value='<?php echo $info_e['event_id']; ?>'>
				<input type="submit" value="Cancel Reservation">
			</form>
		</td>
	</tr>
	<?php
$i++;
}
if(isset($_POST['edit_reservation_data_for_event'])){
	$q3 = "SELECT * FROM events WHERE event_id =".$_POST['edit_reservation_data_for_event'];
	$result3 = mysql_query($q3, $connection);
	$infe = mysql_fetch_array($result3);
	?>
<form action="" method="post">
	<table style="width: 680px; margin: 10px; text-align: left; border: 1px solid grey;">
		<tr>
			<th colspan="100%">
				Event - <?php echo $infe['event_title']; ?>
			</th>
		</tr>
		<?php
			$gg = "SELECT * FROM bring_to_event WHERE event_id ='".$infe['event_id']."'";
			$res = mysql_query($gg, $connection);
			$b_t_e = array();
			while($b_t_ee = mysql_fetch_array($res)){
				$b_t_e[] = $b_t_ee;
			}
			$tt = "SELECT * FROM registered_to_event WHERE event_id ='".$infe['event_id']."'";
			$rez = mysql_query($tt, $connection);
			$r_t_e = array();
			while($r_t_ee = mysql_fetch_array($rez)){
				$r_t_e[] = $r_t_ee;
			}
			if(mysql_num_rows($res)>0){
		?>
		<tr>
			<td style="width: 250px;">
				Required Items:
			</td>
			<td>
				<?php
					foreach($b_t_e as $b_tt){
						//$new_quantity = $b_tt['quantity'];
						//foreach($r_t_e as $r_tt){
						//	if($b_tt['randomPK'] == $r_tt['bring_item_PK']){
						//		$new_quantity = $b_tt['quantity'] - $r_tt['bring_item_amount'];
						//	}
						//}
						echo $b_tt['quantity'];
						echo " - ";
						echo $b_tt['item_name'];
						echo "<br/>";
					}
				?>
			</td>
		</tr>
		<?php } else { echo "<tr><td colspan='100%'>No items need to be brought.</td></tr>";} ?>
		<tr>
			<td style="width: 250px;">
				You are bringing:
			</td>
			<td>
				<?php 
					$p = "SELECT bring_item_amount FROM registered_to_event WHERE event_id ='".$infe['event_id']."' AND user_id ='".$session->username."'";
					$raz = mysql_query($p, $connection);
					$answaaa = mysql_fetch_array($raz);
				if($answaaa['bring_item_amount'] != null && $answaaa['bring_item_amount'] != 0){
				?>
				<input type="text" size="1" placeholder="amt" name="quantity_of_item_to_bring" value="<?php echo $answaaa['bring_item_amount'];?>"/>
				<select name="actual_item_to_bring">
					<?php
						$my_item_pk_is = "";
						foreach($b_t_e as $b_tt){
							$selected = "";
							foreach($r_t_e as $r_tt){
								if($r_tt['bring_item_PK'] == $b_tt['randomPK']){
									$selected = "selected";
									$my_item_pk_is = $r_tt['bring_item_PK']; 
								}
							}
							echo "<option ".$selected." value='".$b_tt['item_name']."'>".$b_tt['item_name']."</option>";
						}
					?>
				</select>
				<?php } else { echo "nothing.";} ?>
			</td>
		</tr>
		<tr>
			<td>
				Guests:
			</td>
			<td><input type="text" size="1" placeholder="amt" name="quantity_of_guests_to_bring" value="<?php echo $r_t_e[0]['bring_num_guests'];?>"/>
				<input type="text" disabled value="guests" size="4"/>
			</td>
		</tr>
		<tr>
			<td colspan="100%" style="width: 180px;">
					<input type="hidden" name="this_item_pk_is" value="<?php echo $my_item_pk_is; ?>" />
					<input type="hidden" name="edit_reservation_data_for_event_now" value='<?php echo $infe['event_id']; ?>'>
					<input type="submit" value="Save">
			</td>
		</tr>
	</table>
</form>
	<?php
}
} else {
	echo "<div id='red_notification_message_box'>You have no reservations</div>";
}
mysql_close($connection);
?>
</table>