<?php
function displayBannedUsers(){
	   global $database;
	   $q = "SELECT username,timestamp "
	       ."FROM ".TBL_BANNED_USERS." ORDER BY username";
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
	   echo "<tr><td><b>Username</b></td><td><b>Time Banned</b></td></tr>\n";
	   for($i=0; $i<$num_rows; $i++){
	      $uname = mysql_result($result,$i,"username");
	      $time  = mysql_result($result,$i,"timestamp");

	      echo "<tr><td>$uname</td><td>$time</td></tr>\n";
	   }
	   echo "</table><br>\n";
	}
?>

<h3>Update User Level</h3>
<?php echo $form->error("upduser"); ?>
<table>
	<form action="index.php?op=control_panel&page=adminprocess" method="POST">
		<tr>
			<td>
				Username:<br>
				<input type="text" name="upduser" maxlength="30" value="<?php echo $form->value("upduser"); ?>">
			</td>
			<td>
				Level:<br>
				<select name="updlevel">
				<option value="1">1
				<option value="9">9
				</select>
			</td>
			<td>
				<br>
				<input type="hidden" name="subupdlevel" value="1">
				<input type="submit" value="Update Level">
			</td>
		</tr>
	</form>
</table>


<h3>Delete User</h3>
<?php echo $form->error("deluser"); ?>
<table>
	<tr>
		<td>
			<form action="index.php?op=control_panel&page=adminprocess" method="POST">
				Username:<br>
				<input type="text" name="deluser" maxlength="30" value="<?php echo $form->value("deluser"); ?>">
				<input type="hidden" name="subdeluser" value="1">
				<input type="submit" value="Delete User">
			</form>
		</td>
	</tr>
</table>

<h3>Delete Inactive Users</h3>
This will delete all users (not administrators), who have not logged in to the site<br>
within a certain time period.<br><br>
<table>
	<form action="index.php?op=control_panel&page=adminprocess" method="POST">
		<tr>
			<td>
				Days:<br>
				<select name="inactdays">
					<option value="3">3
					<option value="7">7
					<option value="14">14
					<option value="30">30
					<option value="100">100
					<option value="365">365
				</select>
			</td>
			<td>
				<br>
				<input type="hidden" name="subdelinact" value="1">
				<input type="submit" value="Delete All Inactive">
			</td>
		</tr>
	</form>
</table>

<h3>Ban User [PERMANENT]</h3>
<?php echo $form->error("banuser"); ?>
<table>
	<tr>
		<td>
			<form action="index.php?op=control_panel&page=adminprocess" method="POST">
				Username:<br>
				<input type="text" name="banuser" maxlength="30" value="<?php echo $form->value("banuser"); ?>">
				<input type="hidden" name="subbanuser" value="1">
				<input type="submit" value="Ban User">
			</form>
		</td>
	</tr>
</table>


<h3>Banned Users Table Contents:</h3>
<?php displayBannedUsers(); ?>


<h3>Delete Banned User</h3>
<?php echo $form->error("delbanuser"); ?>
<table>
	<tr>
		<td>
			<form action="index.php?op=control_panel&page=adminprocess" method="POST">
				Username:<br>
				<input type="text" name="delbanuser" maxlength="30" value="<?php echo $form->value("delbanuser"); ?>">
				<input type="hidden" name="subdelbanned" value="1">
				<input type="submit" value="Delete Banned User">
			</form>
		</td>
	</tr>
</table>