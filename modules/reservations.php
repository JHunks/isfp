<?php
$q = "SELECT * FROM events order by start_time";
$result = mysql_query($q, $connect);

while($all_events = mysql_fetch_array($result)){
?>
	<table style="width: 100%; text-align: left; margin: 10px;">
		<tr>
			<th style="width: 300px; font-size: 20px; vertical-align: top;"><?php echo "[".$all_events['start_time']."] - ".$all_events['event_title']; ?></th>
			<td>
				<?php  
					if($session->logged_in){
						$e = "SELECT * FROM registered_to_event";
						$res = mysql_query($e, $connect);
						while($all_attendees = mysql_fetch_array($res)){	
							if ($all_events['event_id'] == $all_attendees['event_id']){
								$c = "SELECT firstname, lastname FROM users WHERE username ='".$all_attendees['user_id']."'";
								$resul = mysql_query($c, $connect);
								$user = mysql_fetch_array($resul);
								echo $user['firstname']." ".$user['lastname']."<br />";
							}
						}
					} else {
						echo "You have to be logged in to view the guest list.";
					}
				?>
			</td>
		</tr>
	</table>



<?php
}
?>