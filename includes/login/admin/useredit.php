<?php
	include_once("includes/login/include/session.php");
?>
<link rel="stylesheet" href="assets/css/user_update_pass.css">
<link rel="stylesheet" href="assets/css/user_update_info.css">
<script src="includes/calendar-date-input.js" type="text/javascript" charset="utf-8"></script>
<script>
  $(document).ready(function(){
    $("#update_pass_form").validate({
      rules: {
      	curpass: {
          required: true,
          minlength: 5
        },
        newpass: {
          required: true,
          minlength: 5
        },
        newpass_cofirm: {
          required: true,
          minlength: 5,
          equalTo: "#newpass"
        },
        email: {
          required: true,
          email: true
        }
      },
      messages: {
      	curpass: {
          required: "Please provide a password",
          minlength: "Your password must be at least 5 characters long"
        },
        newpass: {
          required: "Please provide a password",
          minlength: "Your password must be at least 5 characters long"
        },
        newpass_cofirm: {
          required: "Please provide a password",
          minlength: "Your password must be at least 5 characters long",
          equalTo: "Please enter the same password as above"
        },
        email: "Please enter a valid email address"
      }
    });
    $("#update_info_form").validate({
      rules: {
      	first_name: {
          required: true,
          minlength: 1
        },
        last_name: {
          required: true,
          minlength: 1
        },
        email: {
          required: true,
          email: true
        },
        phone_: {
          required: true,
          number: true,
          minlength: 10,
          maxlength: 10
        }
      },
      messages: {
      	first_name: {
            required: "Please enter your first name",
            minlength: "Must be at least 1 character long"
        },
        last_name: {
            required: "Please enter your last name",
            minlength: "Must be at least 1 character long"
        },
        email: "Please enter a valid email address",
        phone_: {
          required: "Please provide a phone number",
          minlength: "Must be 10 digits long",
          maxlength: "Must be 10 digits long",
          number: "Must be digits"
        }
      }
    });
  });
</script>

<?php
if(isset($_POST['update_user_information_now'])){
	$connection_cal = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die(mysql_error());
	mysql_select_db(DB_NAME, $connection_cal) or die(mysql_error());

	$f_name = str_replace("'", "\'", $_POST['first_name']);
	$l_name = str_replace("'", "\'", $_POST['last_name']);
	$p_number = str_replace("'", "\'", $_POST['phone_']);
	$e_mail = str_replace("'", "\'", $_POST['email']);
	$schoo_l = str_replace("'", "\'", $_POST['school']);

	$q = "UPDATE users SET firstname = '".$f_name."', lastname = '".$l_name."', email = '".$e_mail."', pnumber = '".$p_number."', school = '".$schoo_l."' WHERE username = '".$session->username."'";
	if(mysql_query($q, $connection_cal)){echo"<div id='blue_notification_message_box'>Success</div>";} else {echo"<div id='red_notification_message_box'>Failure</div>";}
}
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
			<form action="includes/login/process.php" method="POST" id="update_pass_form" class="update_pass_form_class">
				<table style="width: 680px; margin: 10px; text-align: left; border: 1px solid grey;">
					<tr>
						<th colspan="100%">
							Update Password:	
						</th>
					</tr>
					<tr>
						<td></td>
						<td style="width: 200px; padding-left: 5px;">Current Password:</td>
						<td>
							<input type="password" name="curpass" id="curpass" maxlength="30" value="<?php echo $form->value("curpass"); ?>"></td>
						<td><?php echo $form->error("curpass"); ?></td>
					</tr>
					<tr>
						<td></td>
						<td style="width: 200px; padding-left: 5px;">New Password:</td>
						<td>
							<input type="password" name="newpass" id="newpass" maxlength="30" value="<?php echo $form->value("newpass"); ?>"></td>
						<td><?php echo $form->error("newpass"); ?></td>
					</tr>
					<tr>
						<td></td>
						<td style="width: 200px; padding-left: 5px;">Confirm Password:</td>
						<td>
							<input type="password" name="newpass_cofirm" id="newpass_cofirm" maxlength="30" value=""></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td style="width: 200px; padding-left: 5px;">Email:</td>
						<td>
							<input type="text" name="email" maxlength="50" value="<?php if($form->value("email") == ""){ echo $session->userinfo['email']; }else{echo $form->value("email");}?>">
						</td>
						<td><?php echo $form->error("email"); ?></td>
					</tr>
					<tr>
						<td colspan="100%" align="center">
							<br/>
							<input type="hidden" name="subedit" value="1">
							<input type="submit" value="Update Password" class="button3">
						</td>
					</tr>
				</table>
			</form>
			<?php
			$connection_cal = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die(mysql_error());
			mysql_select_db(DB_NAME, $connection_cal) or die(mysql_error());
			$q = "SELECT * FROM users WHERE username = '".$session->username."'";
			$result = mysql_query($q, $connection_cal);
			$info = mysql_fetch_array($result);

			?>
			<form action="" method="POST" id="update_info_form" class="update_info_form_class">
				<table style="width: 680px; margin: 10px; text-align: left; border: 1px solid grey;">
					<tr>
						<th colspan="100%">
							Update Info:	
						</th>
					</tr>
					<tr>
						<td></td>
						<td style="width: 200px; padding-left: 5px;">First Name:</td>
						<td><input type="text" name="first_name" id="first_name" maxlength="30" value="<?php echo $info['firstname']; ?>"></td>
					</tr>
					<tr>
						<td></td>
						<td style="width: 200px; padding-left: 5px;">Last Name:</td>
						<td><input type="text" name="last_name" id="last_name" maxlength="30" value="<?php echo $info['lastname']; ?>"></td>
					</tr>
					<tr>
						<td></td>
						<td style="width: 200px; padding-left: 5px;">Email:</td>
						<td><input type="text" name="email" id="email" maxlength="50" value="<?php echo $info['email']; ?>"></td>
					</tr>
					<tr>
						<td></td>
						<td style="width: 200px; padding-left: 5px;">Phone:</td>
						<td><input type="tel" name="phone_" id="phone_" maxlength="50" value="<?php echo $info['pnumber']; ?>">
						</td>
					</tr>
					<tr>
						<td></td>
						<td style="width: 200px; padding-left: 5px;">School:</td>
						<td>
							<select name="school" id="school" width="20" style="
								                    width: 178px;
								                    height: 38px;
								                    font-family: Calibri, Arial, sans-serif;
								                    font-size: 13px;
								                    font-weight: 400;
								                    text-shadow: 0 1px 0 rgba(255,255,255,0.8);
								                    padding: 10px 18px 10px 10px;
								                    border: none;
								                    border-radius: 5px;
								                    background: #f9f9f9;
								                    color: #777;
								                     ">
								<option value="Ottawa University" <?php if($info['school'] == "Ottawa University"){echo "selected";}?>>Ottawa University</option>
								<option value="Carleton University" <?php if($info['school'] == "Carleton University"){echo "selected";}?>>Carleton University</option>
								<option value="Algonquin College" <?php if($info['school'] == "Algonquin College"){echo "selected";}?>>Algonquin College</option>
								<option value="Other" <?php if($info['school'] == "Other"){echo "selected";}?>>Other</option>
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="100%" align="center">
							<br/>
							<input type="hidden" name="update_user_information_now" value="1">
							<input type="submit" value="Update Info" class="button3">
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