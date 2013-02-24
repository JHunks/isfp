<table>
	<tr>
  		<td>
			<?php
				if($session->logged_in){
					//user loggen in
					?>
						<div id="login_content">
							<ol id="list_container">
								<li id="list_links"><?php echo "<a class='menu' href=\"index.php?op=control_panel\">Control Panel</a>"; ?> </li>
								<li id="list_links"><?php echo "<a class='menu' href=\"includes/login/process.php\">Logout</a>"; ?> </li>
							</ol>
						</div>
				   	<?php
				} else {
					//user logged out
					if($form->num_errors > 0){
					   echo "<font size=\"small\" color=\"#ff0000\">".$form->num_errors." error(s) found</font>";
					}
					?>
						<form action="includes/login/process.php" method="post" name="login_request">
							<table>
								<tr>
									<td>
										<?php echo $form->error("user"); ?>
										<input type="text" name="user" maxlength="30" size="18" value="<?php echo $form->value("user"); ?>">
									</td>
									<td>
										<input type="hidden" name="sublogin" value="1">
										<input type="submit" value="Login">
									</td>
								</tr>
								<tr>
									<td>
										<?php echo $form->error("pass"); ?>
										<input type="password" name="pass" maxlength="30" size="18" value="<?php echo $form->value("pass"); ?>">
									</td>
									<td>
										<input type="checkbox" name="remember" <?php if($form->value("remember") != ""){ echo "checked"; } ?>>
										<font size="1">Rmbr</font>
									</td>
								</tr>
								<tr>
									<td colspan="2" align="left">
										<ol id="list_container"><li id="list_links"><a class='menu' href="index.php?op=forgotpass">Forgot Password?</a></li></ol>
									</td>
								</tr>
							</table>
						</form>
					<?php
				}
			?>
		</td>
	</tr>
</table>