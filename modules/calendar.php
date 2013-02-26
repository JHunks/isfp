<?php
$connection_cal = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die(mysql_error());
mysql_select_db(DB_NAME, $connection_cal) or die(mysql_error());
$q = "SELECT * FROM events";
$result = mysql_query($q, $connection_cal);
?>
<link rel="stylesheet" type="text/css" media="screen" href="assets/css/buttons.css">
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
<div id='calendar'></div>

<?php
if(isset($_GET['id'])){
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
				<h1>Event - <?php echo $infoarray['event_title']; ?></h1>
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
				<a href="#" class="button1">Attend</a>
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
?>
