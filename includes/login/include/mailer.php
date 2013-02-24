<?php 
//include_once("includes/phpmailer/phpmailer.php");
class Mailer{
   function sendWelcome($user, $email, $pass){
      $from = "From: ".EMAIL_FROM_NAME." <".EMAIL_FROM_ADDR.">";
      $subject = "ISFP - Welcome!";
      $body = $user.",\r\n\r\n"
             ."Welcome! You've just registered ISFP \r\n"
             ."with the following information:\r\n\r\n"
             ."Username: ".$user."\r\n"
             ."Password: ".$pass."\r\n\r\n"
             ."If you ever lose or forget your password, a new \r\n"
             ."password will be generated for you and sent to this \r\n"
             ."email address, if you would like to change your \r\n"
             ."email address you can do so by going to the \r\n"
             ."My Account page after signing in.\r\n\r\n";

      return mail($email,$subject,$body,$from);
   }
   function sendNewPass($user, $email, $pass){
      $from = "From: ".EMAIL_FROM_NAME." <".EMAIL_FROM_ADDR.">";
      $subject = "ISFP - Your new password";
      $body = $user.",\r\n\r\n"
             ."We've generated a new password for you at your \r\n"
             ."request, you can use this new password with your \r\n"
             ."username to log in to ISFP.\r\n\r\n"
             ."Username: ".$user."\r\n"
             ."New Password: ".$pass."\r\n\r\n"
             ."It is recommended that you change your password \r\n"
             ."to something that is easier to remember, which \r\n"
             ."can be done by going to the My Account page \r\n"
             ."after signing in.\r\n\r\n";
             
      return mail($email,$subject,$body,$from);
   }
};

?>
