<script src="includes/showHide.js" type="text/javascript"></script>
<style type="text/css">
#slidingDiv{
    background-color: rgba(0,0,0,0.5);
    -webkit-border-radius: 10px 10px 10px 10px;
    -moz-border-radius: 10px 10px 10px 10px;
    border-radius: 10px 10px 10px 10px; 
    display: none;
    text-align: left;
    padding: 10px;
    margin-top: 10px;
    border-left: 1px solid #9d9b9c;
    border-right: 1px solid #9d9b9c;
    border-bottom: 1px solid #9d9b9c;
}
</style>
<?php
$connection_cal = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die(mysql_error());
mysql_select_db(DB_NAME, $connection_cal) or die(mysql_error());
$q = "SELECT * FROM events";
$result = mysql_query($q, $connection_cal);
?>
<script type="text/javascript">
$(document).ready(function() {
	$('#calendar').fullCalendar({
	    events: [
	    	<?php
	    	
	    		while($row = mysql_fetch_array($result)){
	    			echo "{";
	    			echo "title : '".$row['event_title']."',";
	    			echo "start : '".$row['start_time']."',";
	    			if($row['end_time']!="0000-00-00"){
	    				echo "end : '".$row['end_time']."',";
	    			}
	    			echo "url : 'index.php?op=calendar&id=".$row['event_id']."'},";
	    		}
	    		
	    	?>
	        ],
	        eventClick: function(event) {
				if (event.url) {
		            window.location.href = event.url;
		            return false;
		        }
			}    
	});
	$('.show_hide').showHide({			 
		speed: 500,  // speed you want the toggle to happen	
		changeText: 0, // if you dont want the button text to change, set this to 0
		showText: '',// the button text to show when a div is closed
		hideText: '' // the button text to show when a div is open				 
	}); 
});
</script>

<?php 
if(isset($_POST['uninvite_attendant_now'])&& $_POST['uninvite_attendant_now'] == 1){
//uninvite me has been pressed.
	$s = "select randomPK from registered_to_event where user_id ='".$session->username."' and event_id ='".$_POST['uninvite_from_event']."'";
	$my_event_pk = mysql_fetch_array(mysql_query($s, $connection_cal));
	$q = "delete from registered_to_event where randomPK =".$my_event_pk['randomPK'];
	if(mysql_query($q, $connection_cal)){echo"<div id='blue_notification_message_box'>Your reservation for this event has been removed</div>";}else {echo"<div id='red_notification_message_box'>ERROR - Action Terminated</div>";}
}
if(isset($_GET['verify'])&& $_GET['verify'] != null){
//check if the entered url is confirmation reervatio url
	$connection_cal = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die(mysql_error());
	mysql_select_db(DB_NAME, $connection_cal) or die(mysql_error());
	$q = "SELECT * FROM registered_to_event_buffer";
	$result = mysql_query($q, $connection_cal);

	while($row = mysql_fetch_array($result)){
		if($_GET['verify'] == $row['random_hash']){
			$usernooom = $row['username'];
			$myidis = $row['event_id'];
			$willbringitem = $row['bring_item_PK'];
			$willbringamountofitem = $row['bring_item_amount'];
			$willbringguests = $row['bring_num_guests'];
			$connection_gr = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die(mysql_error());
			mysql_select_db(DB_NAME, $connection_gr) or die(mysql_error());
			$k = "DELETE FROM registered_to_event_buffer WHERE username = '$usernooom' AND event_id = '$myidis'";
			if(mysql_query($k, $connection_gr)) {
				$time = time();
				$k = "INSERT INTO registered_to_event VALUES ('$usernooom', '$myidis', '$time', 0, $willbringitem, $willbringamountofitem, $willbringguests)";
				if(mysql_query($k, $connection_gr)) {echo"<div id='blue_notification_message_box'>Your attendance has been confirmed.</div>";}else {echo"<div id='red_notification_message_box'>ERROR - Action Terminated</div>";}
			}else {echo"<div id='red_notification_message_box'>ERROR - Action Terminated</div>";}
		}
	}
}
if(isset($_POST['register_attendee_now']) && $_POST['register_attendee_now'] == 1){
//make a reservation
    $time = time();
    $random_n = sha1(uniqid(mt_rand(), true));
    
    $connection_gr = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die(mysql_error());
	mysql_select_db(DB_NAME, $connection_gr) or die(mysql_error());
	$this_eventtt_id = $_POST['register_attendee_to_this_event'];

	$this_item_random_pk = mysql_fetch_array(mysql_query("SELECT randomPK from bring_to_event where item_name = '".$_POST['actual_item_you_will_bring']."' AND event_id = ".$this_eventtt_id, $connection_cal));
    $this_item_rand_pk = $this_item_random_pk['randomPK'];
    $item_ammmount = $_POST['amount_of_item'];
    $guessst_ammount = $_POST['amount_of_guests'];
    $k = "INSERT INTO registered_to_event_buffer VALUES ('$session->username', '$time', '$random_n', 0, '$this_eventtt_id', '$this_item_rand_pk', $item_ammmount, $guessst_ammount)";
    if(mysql_query($k, $connection_gr)) {
	    include "includes/libmail.php";
	    $m= new Mail('utf-8');  // можно сразу указать кодировку, можно ничего не указывать ($m= new Mail;)
	    $m->From( $site_settings['site_email'] ); // от кого Можно использовать имя, отделяется точкой с запятой
	    $m->To( $session->userinfo['email'] );   // кому, в этом поле так же разрешено указывать имя
	    $m->Subject( "[ISFP: Reservation Confirmation] ".$session->userinfo['username']);
	    $m->Body(
			    	"Good day. \n\nIt has come to our attention that you are trying to attend an event. \nPlease click the link below to confirm that you indeed are going to attend this event\n\n"
			    	.$site_settings['site_url']."/index.php?op=calendar&id=".$_POST['register_attendee_to_this_event'] ."&verify=".$random_n.
			    	"\n\nThank You, ISFP."
				);
	    $m->Priority(4) ;   // установка приоритета
	    $m->smtp_on("ssl://smtp.gmail.com","kirka121@gmail.com","C45tt6KL32", 465, 10); // используя эу команду отправка пойдет через smtp
	    if($m->Send()){echo "<div id='blue_notification_message_box'>Confirmation email has been sent. Please check your inbox to confirm your attendance.</div>";}
	} else {
		echo"<div id='red_notification_message_box'>ERROR - Action Terminated</div>";
	}
}
if ($site_settings['display_calendar'] == 1){
?>
<div style="margin-top: 10px;" id='calendar'></div>
<?php
}
if(isset($_GET['id'])&& $_GET['id'] != null){
	$connection_cal = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die(mysql_error());
	mysql_select_db(DB_NAME, $connection_cal) or die(mysql_error());
	$q = "SELECT * FROM events WHERE event_id='".$_GET['id']."'";
	$result = mysql_query($q, $connection_cal);
	$infoarray = mysql_fetch_array($result);
?>
	<table class="calendar_table">
		<tr>
			<th colspan="3" class="calendar_table" style="font-size: 20px;">
				<?php echo $infoarray['event_title']; ?>
			</th>
		</tr>
		<?php
			if(isset($infoarray['event_description']) && $infoarray['event_description']!=null){
		?>
		<tr>
			<td colspan="3" class="calendar_table_headers">
				Description:
			</td>
		</tr>
		<tr>
			<td colspan="3" class="calendar_table">
				<?php echo $infoarray['event_description']; ?>
				<br/>
				<br/>
			</td>
		</tr>
		<tr>
			<?php } 
				if(isset($infoarray['event_host']) && $infoarray['event_host']!=null){
			?>
			<td class="calendar_table_headers">
				Hosted by:
			</td>
			<td class="calendar_table">
				<?php echo $infoarray['event_host']; ?>
			</td>
			<?php } ?>
			<td rowspan="100%">
				<?php 
					$therewasanerror = false;
					$connection_cal = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die(mysql_error());
					mysql_select_db(DB_NAME, $connection_cal) or die(mysql_error());
					$q = "SELECT * FROM registered_to_event WHERE user_id ='".$session->username."'";
					$result = mysql_query($q, $connection_cal);
					while($infoarr = mysql_fetch_array($result)){
						if($infoarr['event_id'] == $_GET['id']){
							$therewasanerror = true;
						}
					}
					if(!$therewasanerror){
						$zz = "SELECT * FROM registered_to_event_buffer WHERE username ='".$session->username."'";
						$resa = mysql_query($zz, $connection_cal);
						$problema = false;
						while($mydat = mysql_fetch_array($resa)){
							if ($_GET['id'] == $mydat['event_id']){
								$problema=true;
							}
						}
						if(!$problema){
							if($session->logged_in){
							?>
							<div class="show_hide" rel="#slidingDiv">
								<input type="button" value="Attend" class="button1">
							</div>
						<?php } 
						} 
					}?>
			</td>
		</tr>
		<?php 
			if(isset($infoarray['event_location']) && $infoarray['event_location']!=null){
		?>
		<tr>
			<td class="calendar_table_headers">
				Location:
			</td>
			<td class="calendar_table">
				<?php echo $infoarray['event_location']; ?>
			</td>
		</tr>
		<?php } 
			if(isset($infoarray['start_time']) && $infoarray['start_time']!="0000-00-00"){
		?>
		<tr>
			<td class="calendar_table_headers">
				Starts at:
			</td>
			<td class="calendar_table">
				<?php echo $infoarray['start_time']; ?>
				&nbsp;&nbsp;
				[<?php echo $infoarray['start_hour']; ?>]
			</td>
		</tr>
		<?php } 
			if(isset($infoarray['end_time']) && $infoarray['end_time']!="0000-00-00"){
		?>
		<tr>
			<td class="calendar_table_headers">
				Ends at:
			</td>
			<td class="calendar_table">
				<?php echo $infoarray['end_time']; ?>
				&nbsp;&nbsp;
				[<?php echo $infoarray['end_hour']; ?>]
			</td>
		</tr>
		<?php } ?>
		<tr>
			<td class="calendar_table_headers">
				Enterance Fee:
			</td>
			<td class="calendar_table">
				<?php if(isset($infoarray['enterance_fee']) && $infoarray['enterance_fee'] != null && $infoarray['enterance_fee'] != 0 ) {echo "$".$infoarray['enterance_fee'];} else { echo"Free";} ?>
			</td>
		</tr>
		<?php
			$gg = "SELECT * FROM bring_to_event WHERE event_id ='".$infoarray['event_id']."'";
			$res = mysql_query($gg, $connection_cal);
			$tt = "SELECT * FROM registered_to_event WHERE event_id ='".$infoarray['event_id']."'";
			$rez = mysql_query($tt, $connection_cal);
			if(mysql_num_rows($res)>0){
		?>
		<tr>
			<td class="calendar_table_headers">
				Need to bring:
			</td>
			<td class="calendar_table">
				<?php
					while($b_t_e = mysql_fetch_array($res)){
						while($r_t_e = mysql_fetch_array($rez)){
							if($b_t_e['randomPK'] == $r_t_e['bring_item_PK']){
								$new_quantity = $b_t_e['quantity'] - $r_t_e['bring_item_amount'];
							} else {
								$new_quantity = $b_t_e['quantity'];
							}
						}
						echo $new_quantity;
						echo " - ";
						echo $b_t_e['item_name'];
						echo "<br/>";
					}
				?>
			</td>
		</tr>
		<?php } ?>
		<tr>
			<td class="celendar_table_button" colspan="100%">
					<?php 
					$therewasanerror = false;
					$connection_cal = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die(mysql_error());
					mysql_select_db(DB_NAME, $connection_cal) or die(mysql_error());
					$q = "SELECT * FROM registered_to_event WHERE user_id ='".$session->username."'";
					$result = mysql_query($q, $connection_cal);
					while($infoarr = mysql_fetch_array($result)){
						if($infoarr['event_id'] == $_GET['id']){
							?>
								<form method="post" name="uninvite_attendant" class="uninvite_attendant" action="">
									<input type="hidden" name="uninvite_attendant_now" value="1">
									<input type="hidden" name="uninvite_from_event" value="<?php echo $_GET['id'];?>">
									<input type="submit" value="Uninvite Me" class="uninvite_button">
								</form>
							<?php
							$therewasanerror = true;
						}
					}
					if(!$therewasanerror){
						$zz = "SELECT * FROM registered_to_event_buffer WHERE username ='".$session->username."'";
						$resa = mysql_query($zz, $connection_cal);
						$problema = false;
						while($mydat = mysql_fetch_array($resa)){
							if ($_GET['id'] == $mydat['event_id']){
								$problema=true;
							}
						}
						if(!$problema){
							if($session->logged_in){
							?>
							<div id="slidingDiv">
								<form method="post" name="register_attendant" class="register_attendant_form" action="">
									<input type="hidden" name="register_attendee_now" value="1">
									<input type="hidden" name="register_attendee_to_this_event" value="<?php echo $_GET['id'];?>">
									<table>
									<tr>
									<td style="width: 250px; display: inline-table; vertical-align: top;">
										<div style="width: 250px; display: inline-table; vertical-align: top;">
												<?php
													$ge = "SELECT * FROM bring_to_event WHERE event_id ='".$infoarray['event_id']."'";
													$fes = mysql_query($ge, $connection_cal);
													if(mysql_num_rows($fes)>0){
												?> 
													I will bring: <br/>
													<input type="text" placeholder="amt" value="0" name="amount_of_item" size="2">
													<select name="actual_item_you_will_bring">
												<?php
													while($b_t_r = mysql_fetch_array($fes)){
													?>	
														<option value="<?php echo $b_t_r['item_name'];?>"><?php echo $b_t_r['item_name'];?></option>
													<?php
													}
												}?>
											</select>
										</div>
									</td>
									<td style="width: 200px; display: inline-table;">
										<div style="width: 200px; display: inline-table; vertical-align: middle;">
											And:<br/>
											<input type="text" placeholder="amt" value="0" name="amount_of_guests" size="2">
											<input type="text" value="Guests" name="guests" disabled size="6">
										<div>
									</td>
									<td style="display: inline-table; vertical-align: middle;">
										<div style="display: inline-table; vertical-align: middle;">
											<input type="submit" value="Submit" class="button2">
										</div>
									</td>
									</tr>
									</table>
								</form>
							</div>
						<?php } else {
									echo "<div id='red_notification_message_box'>You need to be logged in to attend</div>";
									}
						} else {
							echo "<div id='red_notification_message_box'>There is a pending attendance confirmation on this event.</div>";
						}
					}?>
			</td>
		</tr>
	</table>
<?php 
	}
?>