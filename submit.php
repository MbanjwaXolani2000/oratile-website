<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $subject = $_POST['subject'];
  $option = $_POST['option'];
  $message = $_POST['message'];
  $cv = $_FILES['cv'];

  $to = 'info@oratiletraining.co.za'; 
  $subject = 'Job Application: ' . $subject;
  $headers = 'From: ' . $name . ' <' . $email . '>' . "\r\n";
  $headers .= 'Reply-To: ' . $email . "\r\n";
  $headers .= 'MIME-Version: 1.0' . "\r\n";
  $headers .= 'Content-Type: multipart/mixed; boundary="boundary1"' . "\r\n";
  
  $message_body = "--boundary1\r\n";
  $message_body .= "Content-Type: text/plain; charset=ISO-8859-1\r\n";
  $message_body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
  $message_body .= "Name: " . $name . "\r\n";
  $message_body .= "Email: " . $email . "\r\n";
  $message_body .= "Subject: " . $subject . "\r\n";
  $message_body .= "Option: " . $option . "\r\n";
  $message_body .= "Message: " . $message . "\r\n\r\n";
  
  $file_contents = file_get_contents($cv['tmp_name']);
  $message_body .= "--boundary1\r\n";
  $message_body .= "Content-Type: application/octet-stream; name=\"" . basename($cv['name']) . "\"\r\n";
  $message_body .= "Content-Transfer-Encoding: base64\r\n";
  $message_body .= "Content-Disposition: attachment; filename=\"" . basename($cv['name']) . "\"\r\n\r\n";
  $message_body .= chunk_split(base64_encode($file_contents)) . "\r\n\r\n";
  $message_body .= "--boundary1--";

  if (mail($to, $subject, $message_body, $headers)) {
    echo "Thank you for your application. Your CV has been sent.";
  } else {
    echo "There was an error sending your application. Please try again later.";
  }
}
?>
