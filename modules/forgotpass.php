<?php
include_once("includes/login/include/session.php");

if(isset($_SESSION['forgotpass'])){

   if($_SESSION['forgotpass']){
      echo "<div id='blue_notification_message_box'>Your new password has been sent to your E-Mail.</div>";
   }else{
      echo "<div id='red_notification_message_box'>Failure.</div>>";
   }
       
   unset($_SESSION['forgotpass']);
}else{
?>
  A new password will be generated for you and sent to the email address<br>
  associated with your account, all you have to do is enter your
  username.<br><br>
  <?php echo $form->error("user"); ?>
  <form action="includes/login/process.php" method="POST">
    <b>Username:</b> <input type="text" name="user" maxlength="30" value="<?php echo $form->value("user"); ?>">
    <input type="hidden" name="subforgot" value="1">
    <input type="submit" class="uninvite_button" value="Get New Password">
  </form>

<?php
}
?>
