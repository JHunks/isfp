<link rel="stylesheet" href="assets/css/form.css">
<script>
  $(document).ready(function(){
    $("#si_contact_form1").validate({
      rules: {
        si_contact_ex_field1: {
            required: true,
            minlength: 5,
            maxlength: 40
        },
        si_contact_ex_field2: {
            email: true,
            required: true
        },
        si_contact_ex_field3: {
            required: true,
            minlength: 5,
            maxlength: 60
        },
        si_contact_ex_field4: {
            required: true,
            minlength: 10,
            maxlength: 2000
        }
      },
      messages: {
        si_contact_ex_field1: {
            required: "Please enter first and last name",
            minlength: "Minimum length is 5 characters",
            maxlength: "Maximum length is 60 characters"
        },
        si_contact_ex_field2: {
            email: "Please enter a valid E-mail",
            required: "Please enter an E-Mail"
        },
        si_contact_ex_field3: {
            required: "Please enter a subject",
            minlength: "Minimum length is 5 characters",
            maxlength: "Maximum length is 60 characters"
        },
        si_contact_ex_field4: {
            required: "Please enter a body",
            minlength: "Minimum length is 5 characters",
            maxlength: "Maximum length is 2000 characters"
        }
      }
    });
  });
</script>

<?php
    include_once("includes/login/include/database.php");
    
    $email_from = "kirka121@gmail.com";

    if($_POST){
        $contact_name=$_POST['si_contact_ex_field1'];
        $contact_email=$_POST['si_contact_ex_field2'];
        $contact_subject=$_POST['si_contact_ex_field3'];
        $contact_content=$_POST['si_contact_ex_field4'];
        
        //server side validation
        if ($contact_name == "" || !$contact_name){
            echo "contact name left blank";
        } elseif ($contact_email == "" || !$contact_email){
            echo "contact email left blank";
        } elseif ($contact_subject == "" || !$contact_subject){
            echo "phone number left blank";
        } elseif ($contact_content == "" || !$contact_content){
            echo "original language left blank";
        } else {
            include "includes/libmail.php";
            $m= new Mail('utf-8');  // можно сразу указать кодировку, можно ничего не указывать ($m= new Mail;)
            $m->From( "Kirill;kirka121@gmail.com" ); // от кого Можно использовать имя, отделяется точкой с запятой
            $m->To( $contact_email );   // кому, в этом поле так же разрешено указывать имя
            $m->Subject( "[ISFP: Contact Us]:  ".$contact_subject );
            $m->Body("From: ".$contact_name." (".$contact_email.")"."\nSubject: ".$contact_subject."\nBody: ".$contact_content);
            $m->Priority(4) ;   // установка приоритета
            $m->smtp_on("ssl://smtp.gmail.com","kirka121@gmail.com","C45tt6KL32", 465, 10); // используя эу команду отправка пойдет через smtp
            $m->Send(); // отправка
            echo "Contact us form Sent";

            //insert info into the database.
            mysql_query("INSERT INTO `contact_us` VALUES ('', '$contact_name','$contact_subject','$contact_content','$contact_email');");
        }
    }
?>
<table id="request_quote_table">
    <tr>
        <td>
            <form enctype="multipart/form-data" action="" id="si_contact_form1" class="si_contact_form1" method="post">
                <fieldset>
                    <p>
                        <label for="si_contact_ex_field1_1">Name</label>
                        <input type="text" id="si_contact_ex_field1_1" name="si_contact_ex_field1" size="60" placeholder="First Last Name"/>
                    </p>
                    <p>
                        <label for="si_contact_ex_field1_2">E-Mail</label>
                        <input type="text" id="si_contact_ex_field1_2" name="si_contact_ex_field2" placeholder="Contact E-Mail" size="100" />
                    </p>
                    <p>
                        <label for="si_contact_ex_field1_3">Subject</label>
                        <input type="text" id="si_contact_ex_field1_3" name="si_contact_ex_field3" placeholder="Subject" size="100" />
                    </p>
                    <p>
                        <label for="si_contact_ex_field1_13">Body</label>
                        <textarea id="si_contact_ex_field1_4" name="si_contact_ex_field4" cols="40" rows="15" placeholder="Comments"></textarea>
                    </p>
                    <p id="submit_button">
                        <input type="hidden" name="si_contact_action" value="send" />
                        <input type="hidden" name="si_contact_form_id" value="1" />
                        <input type="submit" value="Send" class="register_button"/>
                    </p>
                </filedset>
            </form>
        </td>
    </tr>
</table>