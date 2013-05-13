<table id="login_table">
	<tr>
  		<td>
			<?php
				if($session->logged_in){
					//user loggen in
					?>
						<div id="login_content_logged_in">
							<ol id="list_container">
								<li id="list_links"><?php echo "<a class='menu' href=\"index.php?op=control_panel\">Control Panel</a>"; ?> </li>
								<li id="list_links"><?php echo "<a class='menu' href=\"includes/login/process.php\">Logout</a>"; ?> </li>
							</ol>
						</div>
				   	<?php
				} else {
					//user logged out
					if($form->num_errors){
					   echo "<font size=\"small\" color=\"#ff0000\">".$form->num_errors." error(s) found</font>";
					}
					?>
					<div id="login_content">
						<form action="includes/login/process.php" method="post" name="login_request">
							<table>
								<tr>
									<td>
										<?php echo $form->error("user"); ?>
										<input type="text" name="user" maxlength="30" size="18" value="<?php echo $form->value("user"); ?>">
									</td>
									<td rowspan="2" id="login_button_table_cell" class="login_table_c_cell">
										<input type="hidden" name="sublogin" value="1">
										<a href="#" class="login_button" onclick="document.login_request.submit()">Login</a>
									</td>
								</tr>
								<tr>
									<td class="login_table_c_cell">
										<?php echo $form->error("pass"); ?>
										<input type="password" name="pass" maxlength="40" size="18" value="<?php echo $form->value("pass"); ?>">
									</td>
								</tr>
								<tr>
									<td colspan="100%" class="login_table_c_cell">
										<input type="checkbox" name="remember" <?php if($form->value("remember") != ""){ echo "checked"; } ?>>
										<font size="1">Remember Me</font>
									</td>
								</tr>
								<tr>
									<td colspan="2" class="login_table_password_cell">
										<a href="index.php?op=forgotpass">Forgot Password?</a>
									</td>
								</tr>
							</table>
						</form>
					</div>
					<?php
				}
			?>
		</td>
	</tr>
</table>