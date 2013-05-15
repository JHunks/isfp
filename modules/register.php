<link rel="stylesheet" href="assets/css/registration.css">
<script src="includes/calendar-date-input.js" type="text/javascript" charset="utf-8"></script>
<script>
  $(document).ready(function(){
    $("#signupForm").validate({
      rules: {
        firstname: {
          required: true,
          minlength: 4
        },
        lastname: {
          required: true,
          minlength: 4
        },
        username: {
          required: true,
          minlength: 5
        },
        password: {
          required: true,
          minlength: 5
        },
        confirm_password: {
          required: true,
          minlength: 5,
          equalTo: "#password"
        },
        email: {
          required: true,
          email: true
        },
        topic: {
          required: "#newsletter:checked",
          minlength: 2
        },
        agree: "required"
      },
      messages: {
        firstname: {
            required: "Please enter your first name",
            minlength: "Must be at least 4 characters long"
        },
        lastname: {
            required: "Please enter your last name",
            minlength: "Must be at least 4 characters long"
        },
        username: {
          required: "Please enter a username",
          minlength: "Your username must consist of at least 5 characters"
        },
        password: {
          required: "Please provide a password",
          minlength: "Your password must be at least 5 characters long"
        },
        confirm_password: {
          required: "Please provide a password",
          minlength: "Your password must be at least 5 characters long",
          equalTo: "Please enter the same password as above"
        },
        email: "Please enter a valid email address",
        agree: "Please accept our policy"
      }
    });
    // propose username by combining first- and lastname
    $("#username").focus(function() {
      var firstname = $("#firstname").val();
      var lastname = $("#lastname").val();
      if(firstname && lastname && !this.value) {
        this.value = firstname + lastname;
      }
    });

  });
</script>
<?php
//The user is already logged in, not allowed to register.
if($session->logged_in){
   echo "<div id='red_notification_message_box'>You are already registered, $session->username";
}
//The user has submitted the registration form and theresults have been processed.
else if(isset($_SESSION['regsuccess'])){
   // Registration was successful
   if($_SESSION['regsuccess']){
      echo "<div id='blue_notification_message_box'>Success, Your information has been added to the database.";
   }
   // Registration failed
   else{
      echo "<div id='red_notification_message_box'>Registration has failed.";
   }
   unset($_SESSION['regsuccess']);
   unset($_SESSION['reguname']);
}
/*
  The user has not filled out the registration form yet.
  Below is the page with the sign-up form, the names
  of the input fields are important and should not
  be changed.
 */
else{
?>
<table id="register_table">
  <tr>
    <td>
      <form class="cmxform" id="signupForm" action="includes/login/process.php" method="POST">
        <fieldset>
          <?php if($form->error("firstname")){ ?>
            <p>
              <label><font size="2" color="#ff0000">Error</font></label>
              <?php echo $form->error("firstname"); ?>
            </p>
          <?php } ?>
          <p>
            <label for="firstname">First name</label>
            <input id="firstname" name="firstname" type="text" placeholder="First Name" />
          </p>
          <?php if($form->error("lastname")){ ?>
            <p>
              <label><font size="2" color="#ff0000">Error</font></label>
              <?php echo $form->error("lastname"); ?>
            </p>
          <?php } ?>
          <p>
            <label for="lastname">Last name</label>
            <input id="lastname" name="lastname" type="text" placeholder="Last Name" />
          </p>
          <?php if($form->error("user")){ ?>
            <p>
              <label><font size="2" color="#ff0000">Error</font></label>
              <?php echo $form->error("user"); ?>
            </p>
          <?php } ?>
          <p>
            <label for="username">User name</label>
            <input id="username" name="username" type="text" placeholder="Username" />
          </p>
          <?php if($form->error("pass")){ ?>
            <p>
              <label><font size="2" color="#ff0000">Error</font></label>
              <?php echo $form->error("pass"); ?>
            </p>
          <?php } ?>
          <p>
            <label for="password">Password</label>
            <input id="password" name="password" type="password" placeholder="Password"/>
          </p>
          <p>
            <label for="confirm_password">Confirm password</label>
            <input id="confirm_password" name="confirm_password" type="password" placeholder="Confirm" />
          </p>
          <?php if($form->error("email")){ ?>
            <p>
              <label><font size="2" color="#ff0000">Error</font></label>
              <?php echo $form->error("email"); ?>
            </p>
          <?php } ?>
          <p>
            <label for="school">School</label>
            <select id="school" name="school" width="20" style="
                    width: 175px;
                    height: 34px;
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
              <option>Ottawa University</option>
              <option>Carleton University</option>
              <option>Algonquin College</option>
              <option>Other</option>
            </select>
          </p>
          <p>
            <label for="email">Email</label>
            <input id="email" name="email" type="email" placeholder="E-Mail"/>
          </p>
          <p>
            <label for="agree">Please agree to <a href="#" class="inner_link">our policy</a></label>
            <input type="checkbox" class="checkbox" id="agree" name="agree" />
          </p>
          <p id="submit_button">
            <input type="hidden" name="subjoin" value="1">
            <input class="register_button" type="submit" value="Register">
          </p>
        </fieldset>
      </form>
    </td>
  </tr>
</table>
<?php
}
?>
