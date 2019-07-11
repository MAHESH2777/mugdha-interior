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
  $captcha;
if (isset($_POST['g-recaptcha-response'])) {
$captcha = $_POST['g-recaptcha-response'];
}
if (!$captcha) {
echo '<script>
//Using setTimeout to execute a function after 5 seconds.
setTimeout(function () {
  //Redirect with JavaScript
  window.location.href="captch.php";
}, 1000);
</script>';
exit;
}
$secretKey = "6LfauawUAAAAAGjvKqaT6zXTO40AlZSEwLz_7DQg";
$ip = $_SERVER['REMOTE_ADDR'];
// post request to server
$url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) . '&response=' . urlencode($captcha);
$response = file_get_contents($url);
$responseKeys = json_decode($response, true);
// should return JSON with success as true
if ($responseKeys["success"]) {
echo '<h2>Thanks for posting comment</h2>';
} else {
echo '<h2>You are spammer ! Get the @$%K out</h2>';
}
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

<form name="myForm" action="" method="POST" onsubmit="return myFun()">
  <div class="md-form">
    <i class="fa fa-user prefix grey-text"></i>
    <input type="text" name="name" class="form-control" autocomplete="off" required>
    <label for="form31">Your name</label>
  </div>
  <div class="md-form">
    <i class="fa fa-envelope prefix grey-text"></i>
    <input type="text" name="email" class="form-control" autocomplete="off" required>
    <label for="form21">Your email</label>
  </div>
  <div class="md-form">
    <i class="fa fa-phone prefix grey-text"></i>
    <input type="number" name="number" id="mobile-number" autocomplete="off" class="form-control">
    <span id="Mes"> </span>
    <label for="form341">Phone</label>
  </div>
  <div class="md-form">
    <i class="fa fa-pencil prefix grey-text"></i>
    <textarea type="text" name="message" class="md-textarea" style="height: 100px"></textarea>
    <label for="form81">Your message</label>
  </div>
  <div class="g-recaptcha" data-sitekey="6LfauawUAAAAAJomiLf6OY2Lm3sEeHm_tU3ET10J"></div>
  <div class="text-center">
    <button class="btn fbtn btn-lg" name="submit" type="submit" id="" value="send" name="save">Send</button>
  </div>
</form>

          <script>
            function myFun() {

              var a = document.getElementById("mobile-number").value;
              if (a == "") {
                document.getElementById("Mes").innerHTML = "Please Enter Mobile Number";
                return false;
              }
              if (isNaN(a)) {
                document.getElementById("Mes").innerHTML = "Please Enter Numeric values";
                return false;
              }
              if (a.length > 15) {
                document.getElementById("Mes").innerHTML = "Mobile Number must be below 15 digits";
                return false;
              }
              if (a.length < 9) {
                document.getElementById("Mes").innerHTML = "Mobile Number must be 10 digits ";
                return false;
              }
            }
          </script>
        </div>
      </div>
    </div>
  </div>
</div>