<?php
/**
* This example shows how to handle a simple contact form.
*/
//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$msg = '';
//Don't run this unless we're handling a form submission
if (array_key_exists('email', $_POST)) {
date_default_timezone_set('Etc/UTC');
require 'vendor/autoload.php';
//Create a new PHPMailer instance
$mail = new PHPMailer;
//Tell PHPMailer to use SMTP - requires a local mail server
//Faster and safer than using mail()
$mail->isSMTP();
$mail->Host = "tls://smtp.zoho.com";

$mail->Port = 587; 

$mail->SMTPAuth = true;
$mail->Username = 'info@mugdhainteriors.com';
$mail->Password = 'Pwd@info1234';
$mail->SMTPSecure = 'tls';
$mail->smtpConnect(
array(
"ssl" => array(
"verify_peer" => false,
"verify_peer_name" => false,
"allow_self_signed" => true
)
)
);
// $mail->Port = 25;
//Use a fixed address in your own domain as the from address
//**DO NOT** use the submitter's address here as it will be forgery
//and will cause your messages to fail SPF checks
$mail->setFrom('info@mugdhainteriors.com', 'First Last');
//Send the message to yourself, or whoever should receive contact for submissions
$mail->addAddress('info@mugdhainteriors.com', 'John Doe');
//Put the submitter's address in a reply-to header
//This will fail if the address provided is invalid,
//in which case we should ignore the whole request
if ($mail->addReplyTo($_POST['email'], $_POST['name'])) {
$mail->Subject = 'PHPMailer contact form';
//Keep it simple - don't use HTML
$mail->isHTML(false);
//Build a simple message body
$mail->Body = <<<EOT
Email: {$_POST['email']}
Name: {$_POST['name']}
Number: {$_POST['number']}
Message: {$_POST['message']}
EOT;
//Send the message, check for errors
if (!$mail->send()) {
//The reason for failing to send will be in $mail->ErrorInfo
//but you shouldn't display errors to users - process the error, log it on your server.
$msg = 'Sorry, something went wrong. Please try again later.';
} else {
$msg = 'Message sent! Thanks for contacting us.';
}
} else {
$msg = 'Invalid email address, message ignored.';
}

}
?>
<form name="myForm" id="contact" action="" method="POST" onsubmit="return myFun()">
      <h2 class="h1tag">Quick Contact</h2>
      <h4>Contact us today, and get reply with in 24 hours!</h4>
      <fieldset>
      
        <input placeholder="Yourname" name="name" type="text" tabindex="1" required>
       
      </fieldset>
      <fieldset>
        <input placeholder="Your Email Address" name="email"  type="email" tabindex="2" >
        <span id="Message"> </span>
      </fieldset>
      <fieldset>
        <input placeholder="Your Phone Number" name="number" id="mobilenumber" type="tel" tabindex="3">
             <span id="Message"> </span>
      </fieldset>
      <fieldset>
        <textarea placeholder="Type your Message Here...." name="message" tabindex="5"></textarea>
      </fieldset>
      <fieldset>
        <button name="submit" type="submit" id="contact-submit" value="send" name="save" data-submit="...Sending">Submit</button>
      </fieldset>
    </form>
    <script>

// function myFun() {
// 	var a = document.myForm.email.value;     // raju@gmail.com
// 	if(a.indexOf('@')<=0) {   //@gmail.com
// 		document.getElementById("Message").innerHTML ="Invalid @ position ";
// 		return false;
// 	}
// 	//thapa@gmail.com  
// 	if(a.charAt(a.length-4)!='.') {
// 		document.getElementById("Message").innerHTML ="Invalid . position ";
// 		return false;
// 	}
// 	//thapa@gmail.co
// 	if(a.charAt(a.length-4)!='.') {
// 		document.getElementById("Message").innerHTML ="Invalid . positionss ";
// 		return false;
//   }
// }

  </script>
  <script>
function myFun() {
	
	var a = document.getElementById("mobilenumber").value;   
	if(a == "") {  
		document.getElementById("Message").innerHTML ="Please Enter Mobile Number";
		return false;
	}
	if(isNaN(a)) {  
		document.getElementById("Message").innerHTML ="Please Enter Numeric values";
		return false;
	}
	
	if(a.length<10) {
		document.getElementById("Message").innerHTML ="Mobile Number must be 10 digits";
		return false;
	}
	
	if(a.length>10) {
		document.getElementById("Message").innerHTML ="Mobile Number must be 10 digits ";
		return false;
	}
	
}
</script>

