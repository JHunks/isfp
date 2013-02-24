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
<div id='calendar'></div>