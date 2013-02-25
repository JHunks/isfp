<?php
if($session->logged_in){
   echo "<h1>Registered</h1>";
   echo "<p>We're sorry <b>$session->username</b>, but you've already registered. "
       ."<a href=\"/index.php\">Home</a>.</p>";
} else if(isset($_SESSION['regsuccess'])){
   /* Registration was successful */
   if($_SESSION['regsuccess']){
      echo "<h1>Registered!</h1>";
      echo "<p>Thank you <b>".$_SESSION['reguname']."</b>, your information has been added to the database, "
          ."you may now <a href=\"/index.php\">log in</a>.</p>";
   }
   /* Registration failed */
   else{
      echo "<h1>Registration Failed</h1>";
      echo "<p>We're sorry, but an error has occurred and your registration for the username <b>".$_SESSION['reguname']."</b>, "
          ."could not be completed.<br>Please try again at a later time.</p>";
   }
   unset($_SESSION['regsuccess']);
   unset($_SESSION['reguname']);
}
else{
?>
<h1>Register</h1>
<?php
  if($form->num_errors > 0){
     echo "<td><font size=\"2\" color=\"#ff0000\">".$form->num_errors." error(s) found</font></td>";
  }
?>
<form action="includes/login/process.php" method="POST">
  <table>
    <tr>
      <td>Username:</td>
      <td><input type="text" name="user" maxlength="30" value="<?php echo $form->value("user"); ?>"></td>
      <td><?php echo $form->error("user"); ?></td>
    </tr>
    <tr>
      <td>Password:</td>
      <td><input type="password" name="pass" maxlength="30" value="<?php echo $form->value("pass"); ?>"></td>
      <td><?php echo $form->error("pass"); ?></td>
    </tr>
    <tr>
      <td>Email:</td>
      <td><input type="text" name="email" maxlength="50" value="<?php echo $form->value("email"); ?>"></td>
      <td><?php echo $form->error("email"); ?></td>
    </tr>
    <tr>
      <td colspan="3" align="right"><input type="hidden" name="subjoin" value="1"><input type="submit" value="Register!"></td>
    </tr>
  </table>
</form>

<?php
}
?> 
