<?php 
$name = $_POST['name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$DoS = $_POST['DoS'];
$sCheck = $_POST['sCheck'];
$pCheck = $_POST['pCheck'];
$message = $_POST['message'];
$formcontent="From: $name \n $sCheck \n $pCheck \n Message: $message";
$recipient = "tyeson@dppidaho.com, mike.emerich@gmail.com";
$subject = "Customer Review Feedback";
$mailheader = "From: $email \n Phone: $phone \n Date of service: $DoS \r\n";
mail($recipient, $subject, $formcontent, $mailheader) or die("Error!");
echo "Thank You!";
header("Location: https:\\ArtsignDesign.com");
?>