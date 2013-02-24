<?php
/*
include_once("includes/phpmailer/class.phpmailer.php");
  $mail = new PHPMailer();
  $mail->IsSMTP();
  // enable SMTP authentication
  $mail->SMTPAuth = true;
  // sets the prefix to the server
  $mail->SMTPSecure = "ssl";
  // sets GMAIL as the SMTP server
  $mail->Host = 'smtp.gmail.com';
  // set the SMTP port
  $mail->Port = '465';
  // GMAIL username
  $mail->Username = 'kirka121@gmail.com';
  // GMAIL password
  $mail->Password = 'C45tt6KL32';

  $mail->From = 'kirka121@gmail.com';
  $mail->FromName = 'Kirill';
  $mail->AddReplyTo('kirka121@gmail.com', 'Kirill');
  $mail->Subject = 'Test Gmail!';

  $text_message = "Kirka".",\r\n\r\n"
             ."We've generated a new password for you at your \r\n"
             ."request, you can use this new password with your \r\n"
             ."username to log in to ISFP.\r\n\r\n"
             ."Username: "."Kirka"."\r\n"
             ."New Password: "."asdasdasdasdasdas"."\r\n\r\n"
             ."It is recommended that you change your password \r\n"
             ."to something that is easier to remember, which \r\n"
             ."can be done by going to the My Account page \r\n"
             ."after signing in.\r\n\r\n";

  $mail->Body = $text_message;
  $mail->IsHTML(false);

  $mail->AddAddress('kirka121@gmail.com', 'blaaae');

  if(!$mail->Send()){
      echo $mail->ErrorInfo;
  }else{
      $mail->ClearAddresses();
      $mail->ClearAttachments();
  }
  */
?>



<?php

include_once("includes/login/include/session.php");

if(isset($_SESSION['forgotpass'])){

   if($_SESSION['forgotpass']){
      echo "<h1>New Password Generated</h1>";
      echo "<p>Your new password has been generated "
          ."and sent to the email <br>associated with your account. "
          ."<a href=\"index.php\">Main</a>.</p>";
   }

   else{
      echo "<h1>New Password Failure</h1>";
      echo "<p>There was an error sending you the "
          ."email with the new password,<br> so your password has not been changed. "
          ."<a href=\"index.php\">Main</a>.</p>";
   }
       
   unset($_SESSION['forgotpass']);
}
else{


?>
<h1>Forgot Password</h1>
A new password will be generated for you and sent to the email address<br>
associated with your account, all you have to do is enter your
username.<br><br>
<?php echo $form->error("user"); ?>
<form action="includes/login/process.php" method="POST">
  <b>Username:</b> <input type="text" name="user" maxlength="30" value="<?php echo $form->value("user"); ?>">
  <input type="hidden" name="subforgot" value="1">
  <input type="submit" value="Get New Password">
</form>

<?php
}

?>
