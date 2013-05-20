<?php
if(!$session->isAdmin()){
	die("you should not be here. ip recorded, errors logged.");
} 
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
	   echo "<table class='edit_data'>\n";
	   echo "<tr><td class='edit_data'><b>Username</b></td><td></td><td class='edit_data'><b>Level</b></td><td></td><td class='edit_data'><b>Email</b></td><td></td><td class='edit_data'><b>Last Active</b></td></tr>\n";
	   for($i=0; $i<$num_rows; $i++){
	      $uname  = mysql_result($result,$i,"username");
	      $ulevel = mysql_result($result,$i,"userlevel");
	      $email  = mysql_result($result,$i,"email");
	      $time   = mysql_result($result,$i,"timestamp");

	      echo "<tr><td class='edit_data'>$uname</td><td> | </td><td class='edit_data'>$ulevel</td><td> | </td><td class='edit_data'>$email</td><td> | </td><td class='edit_data'>".date('[Y-m-d]', $time)."</td></tr>\n";
	   }
	   echo "</table><br>\n";
	}
	?>

<table class="edit_data">
	<tr>
		<td class="edit_data"><?php displayUsers(); ?></td>
	</tr>
</table>