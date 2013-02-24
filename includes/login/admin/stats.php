<?php 
	function displayUsers(){
	   global $database;
	   $q = "SELECT username,userlevel,email,timestamp "
	       ."FROM ".TBL_USERS." ORDER BY userlevel DESC,username";
	   $result = $database->query($q);
	   /* Error occurred, return given name by default */
	   $num_rows = mysql_numrows($result);
	   if(!$result || ($num_rows < 0)){
	      echo "Error displaying info";
	      return;
	   }
	   if($num_rows == 0){
	      echo "Database table empty";
	      return;
	   }
	   /* Display table contents */
	   echo "<table align=\"left\" border=\"1\" cellspacing=\"0\" cellpadding=\"3\">\n";
	   echo "<tr><td><b>Username</b></td><td><b>Level</b></td><td><b>Email</b></td><td><b>Last Active</b></td></tr>\n";
	   for($i=0; $i<$num_rows; $i++){
	      $uname  = mysql_result($result,$i,"username");
	      $ulevel = mysql_result($result,$i,"userlevel");
	      $email  = mysql_result($result,$i,"email");
	      $time   = mysql_result($result,$i,"timestamp");

	      echo "<tr><td>$uname</td><td>$ulevel</td><td>$email</td><td>$time</td></tr>\n";
	   }
	   echo "</table><br>\n";
	}
	?>

<table>
	<tr>
		<td><?php displayUsers(); ?></td>
	</tr>
</table>