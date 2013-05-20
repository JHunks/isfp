<?php
	include_once("includes/login/include/session.php");
?>
<table class="edit_links">
	<tr>
		<td class="edit_links">
			<p>
				<?php
					if(isset($_SESSION['useredit'])){
					   unset($_SESSION['useredit']);
					   echo "<h1>User Account Edit Success!</h1>";
					   echo "<p> <b>$session->username</b>, your account has been successfully updated. ";
					} else {
				?>
				<?php
					if($session->logged_in){
				?>
			</p>
			<?php
				if($form->num_errors > 0){
	   				echo "<td> <font size=\"2\" color=\"#ff0000\">".$form->num_errors." error(s) found</font></td>";
				}
			?>
			<form action="includes/login/process.php" method="POST">
				<table>
					<tr>
						<td></td>
						<td>Current Password:</td>
						<td>
							<input type="password" name="curpass" maxlength="30" value="<?php echo $form->value("curpass"); ?>"></td>
						<td><?php echo $form->error("curpass"); ?></td>
					</tr>
					<tr>
						<td></td>
						<td>New Password:</td>
						<td>
							<input type="password" name="newpass" maxlength="30" value="<?php echo $form->value("newpass"); ?>"></td>
						<td><?php echo $form->error("newpass"); ?></td>
					</tr>
					<tr>
						<td></td>
						<td>Email:</td>
						<td>
							<input type="text" name="email" maxlength="50" value="<?php if($form->value("email") == ""){ echo $session->userinfo['email']; }else{echo $form->value("email");}?>">
						</td>
						<td><?php echo $form->error("email"); ?></td>
					</tr>
					<tr>
						<td colspan="2" align="right">
							<input type="hidden" name="subedit" value="1">
							<input type="submit" value="Edit Account">
						</td>
					</tr>
				</table>
			</form>
			<?php
					}
				}
			?>
		</td>
	</tr>
</table>