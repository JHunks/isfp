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
		})
	});
</script>

<?php 
if(isset($_POST['register_attendee_now']) && $_POST['register_attendee_now'] == 1){

    $contact_name=$_POST['si_contact_ex_field1'];
    $contact_email=$_POST['si_contact_ex_field2'];
    $contact_subject=$_POST['si_contact_ex_field3'];
    $contact_content=$_POST['si_contact_ex_field4'];
    $time = time();

    include "includes/libmail.php";
    $m= new Mail('utf-8');  // можно сразу указать кодировку, можно ничего не указывать ($m= new Mail;)
    $m->From( "Kirill;kirka121@gmail.com" ); // от кого Можно использовать имя, отделяется точкой с запятой
    $m->To( $session->userinfo['email'] );   // кому, в этом поле так же разрешено указывать имя
    $m->Subject( "[ISFP: Reservation Confirmation] ".$session->userinfo['username']);
    $m->Body("From: ".$contact_name." (".$contact_email.")"."\nSubject: ".$contact_subject."\nBody: ".$contact_content);
    $m->Priority(4) ;   // установка приоритета
    $m->smtp_on("ssl://smtp.gmail.com","kirka121@gmail.com","C45tt6KL32", 465, 10); // используя эу команду отправка пойдет через smtp
    $m->Send(); // отправка
    echo "Confirmation email has been sent. Please check your inbox to confirm your attendance.";

    //insert info into the database.
    mysql_query("INSERT INTO `restered_to_event_buffer` VALUES ($session->userinfo['username'], $time;");
        




}



if(isset($dbarray['calendar_op']) && $dbarray['calendar_op']==1){
	$connection_cal = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die(mysql_error());
	mysql_select_db(DB_NAME, $connection_cal) or die(mysql_error());
	$q = "SELECT * FROM events";
	$result = mysql_query($q, $connection_cal);
	?>
	<table>

	<?php



	while($infoarray = mysql_fetch_array($result)){
		?>
			<tr>
				<td><?php echo $infoarray['event_title']; ?></td>
				<td><?php echo $infoarray['event_description']; ?></td>
				<td><?php echo $infoarray['event_host']; ?></td>
				<td><?php echo $infoarray['event_location']; ?></td>
				<td><?php echo $infoarray['start_time']; ?></td>
				<td><?php echo $infoarray['end_time']; ?></td>
				<td><?php echo $infoarray['guest_list']; ?></td>
				<td><?php echo $infoarray['enterance_fee']; ?></td>
			</tr>

		<?php
	}
	?>
	</table>
	<?php

} else { 
?>

<!--<div id='calendar'></div>-->


<?php
if(isset($_GET['id'])&& $_GET['id'] != null){
	$connection_cal = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die(mysql_error());
	mysql_select_db(DB_NAME, $connection_cal) or die(mysql_error());
	$q = "SELECT * FROM events WHERE event_id='".$_GET['id']."'";
	$result = mysql_query($q, $connection_cal);
	$infoarray = mysql_fetch_array($result);
?>
<div id="calendar_display">
	<table class="calendar_table">
		<tr>
			<th colspan="3" class="calendar_table">
				<h1><?php echo $infoarray['event_title']; ?></h1>
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
		<?php } 
			if(isset($infoarray['event_host']) && $infoarray['event_host']!=null){
		?>
		<tr>
			<td class="calendar_table_headers">
				Hosted by:
			</td>
			<td class="calendar_table">
				<?php echo $infoarray['event_host']; ?>
			</td>
			<td class="celendar_table_button" rowspan="100%">
				<?php if ($session->logged_in){ ?>
					<form method="post" name="register_attendant" class="register_attendant_form" action="">
						<input type="hidden" name="register_attendee_now" value="1">
						<input type="submit" value="Attend" class="button1">
					</form>
				<?php }?>
			</td>
		</tr>
		<?php } 
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
			</td>
		</tr>
		<?php } 
			if(isset($infoarray['guest_list']) && $infoarray['guest_list']!=null){
		?>
		<tr>
			<td class="calendar_table_headers">
				Guest List:
			</td>
			<td class="calendar_table">
				<?php echo $infoarray['guest_list']; ?>
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
	</table>
</div>
<?php 
	}
}
?>
