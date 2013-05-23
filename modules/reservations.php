<?php
$q = "SELECT * FROM events order by start_time";
$result = mysql_query($q, $connect);


if (!$session->logged_in){
	echo "<div id='red_notification_message_box'>You have to be logged in to view reservations</div>";
} else {
?>
<table style="width: 100%; text-align: left; margin: 10px;">
	<tr>
		<td style="width: 200px;">
			Event:
		</td>
		<td style="width: 150px;">
			Attendee:
		</td>
		<td style="width: 150px;">
			Items:
		</td>
		<td style="width: 150px;">
			Guests:
		</td>
	</tr>
</table>
<?php
while($all_events = mysql_fetch_array($result)){
	echo "<hr/>";
?>
	<table style="width: 100%; text-align: left; margin: 10px;">
		<tr>
			
			<th style="width: 215px; font-size: 16px; vertical-align: top;">
				<a href="index.php?op=calendar&id=<?php echo $all_events['event_id']; ?>">
					<?php echo "[".$all_events['start_time']."] - ".$all_events['event_title']; ?>
				</a>
			</th>
			<td colspan="3" style="width: 450px;">
				<table>
					<?php  
						if($session->logged_in){
							$e = "SELECT * FROM registered_to_event";
							$res = mysql_query($e, $connect);
							$i = 0;
							while($all_attendees = mysql_fetch_array($res)){	
								if ($all_events['event_id'] == $all_attendees['event_id']){
									$c = "SELECT firstname, lastname FROM users WHERE username ='".$all_attendees['user_id']."'";
									$resul = mysql_query($c, $connect);
									$user = mysql_fetch_array($resul);
									echo 
										"<tr>
											<td style='width:165px;'>".
												$user['firstname']." ".$user['lastname'].
											"</td>
											<td style='width:165px;'>";
												if($all_attendees['bring_item_amount'] != null && $all_attendees['bring_item_amount'] != 0){
													$p = "SELECT item_name FROM bring_to_event WHERE randomPK =".$all_attendees['bring_item_PK'];
													$raz = mysql_query($p, $connect);
													$answaaa = mysql_fetch_array($raz);
													echo $all_attendees['bring_item_amount']." x ".$answaaa['item_name'];
												} else {
													echo "<div style='font-size: 12px; padding-top: 7px;'>none</div>";
												}
											echo "</td><td style='width:100px;'>";
												if($all_attendees['bring_num_guests'] != null && $all_attendees['bring_num_guests'] != 0){
													echo $all_attendees['bring_num_guests']; 
												} else {
													echo "<div style='font-size: 12px; padding-top: 7px;'>none</div>";
												}
											echo "</td></tr>";
									$i++;
								} 
							}
							if($i==0){
								echo "<tr><td><div style='font-size: 12px; padding-top: 7px;'>none</div></td></tr>";
							}
						} else {
							echo "";
						}
					?>
				</table>
			</td>
		</tr>
	</table>
<?php
}
}
?>