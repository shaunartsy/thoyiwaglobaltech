<?php 

	$to = ""; // this is your Email address
	$from  = $_POST['email']; // this is the sender's Email address
	$f_name = $_POST['f_name'];
	$l_name = $_POST['l_name'];
	$phone = $_POST['phone'];
	$note = $_POST['note'];

	$subject = "Form submission";
	$message = $f_name . " " . $l_name . " has send the contact message. His / her phone number is : " .  $phone . ". He / she worte the following... ". "\n\n" . $note;

	$headers = 'From: ' . $from;
	mail($to, $subject, $message, $headers);

?>