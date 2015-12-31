<?php
if (isset($_POST['email'])) {
    $email_to = "caseycrogers@berkeley.edu";
    $email_subject = "This is from your website contact form";
    $email_from = "caseycrogers.com";

    function died($error){
        echo "Message failed to send:<br/><br/>";
        echo $error. "<br/>";
        die();
    }
    //validation
    if(!isset($_POST['name']) || !isset($_POST['email']) ||
        !isset($_POST['subject']) || !isset($_POST['message'])) {
        died('Please complete all fields.');
    }
    $name  = $_POST['name'];
    $email = $_POST['email'];
    $subject  = $_POST['subject'];
    $message  = $_POST['message'];

    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9._%-]+\.[A-Za-z]{2,4}$/'
    if(!preg_match($email_exp, $email)) {
        $error_message .= 'Invalid e-mail address.<br/>';
    }
    $string_exp = "/^[A-Za-z.'-]+$/";
    if(!preg_match($string_exp, $name)) {
        $error_message .= 'Invalid character in the name field.<br/>';
    }
    if(strlen($error_message) > 0) {
        died($error_message);
    }
    $email_message = "Form Details below.\n\n";

    function clean_string($string) {
        $bad = array("content-type", "bcc:", "to:", "cc:", "href");
        return str_replace($bad, "", $string);
    }
    $email_message .= "Name:" . clean_string($name) . "\n";
    $email_message .= "Email:" . clean_string($email) . "\n";
    $email_message .= "Subject:" . clean_string($subject) . "\n";
    $email_message .= "Message:" . clean_string($message) . "\n";

    $headers = "From: ' .$email_From . "\r\n". "Reply-To" . $email. "\r\n" . 
    "X-Mailer: PHP/" . phpversion();"
    @mail($email_to, $email_subject, $email_message, $headers);
?>
Message sent successfully!<br/>
<?php 
}
?>