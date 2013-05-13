<script>
  $(document).ready(function(){
    $("#login_request").validate({
      rules: {
        username: {
          required: true,
          minlength: 5
        },
        password: {
          required: true,
          minlength: 5
        }
      },
      messages: {
        username: {
          required: "Enter a username",
          minlength: "Minimum 5 characters"
        },
        password: {
          required: "Provide a password",
          minlength: "Minimum 5 characters"
        }
      }
    });
  });
</script>

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
					?>
					<div id="login_content">
						<form action="includes/login/process.php" method="post" name="login_request" id="login_request">
							<table>
								<tr>
									<td>
										<?php echo $form->error("username"); ?>
										<label for="username"></label>
										<input type="text" name="username" maxlength="30" size="18" value="<?php echo $form->value("username"); ?>" placeholder="username">
									</td>
									<td rowspan="2" style="padding-left: 4px; padding-top: 1px;">
										<input type="hidden" name="sublogin" value="1">
										<input type="submit" value="Login" class="login_button"/>
									</td>
								</tr>
								<tr>
									<td >
										<?php echo $form->error("password"); ?>
										<label for="password"></label>
										<input type="password" name="password" maxlength="40" size="18" value="<?php echo $form->value("password"); ?>" placeholder="password">
									</td>
								</tr>
								<tr>
									<td colspan="100%" >
										<input type="checkbox" name="remember" <?php if($form->value("remember") != ""){ echo "checked"; } ?>>
										<font size="1">Remember Me</font>
									</td>
								</tr>
								<tr>
									<td colspan="2">
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