<?php

$address = 'YOUR_EMAIL_ADDRESS'; // your email address

$email=$_POST['email'];
$subject = 'New Subscriber: ' . $email;
$body = 'New Subscriber: ' . $email;
$headers = 'From: ' . $email . PHP_EOL . 'Reply-To: ' . $email . PHP_EOL . 'MIME-Version: 1.0' . PHP_EOL . 'Content-type: text/plain; charset=utf-8' . PHP_EOL . 'Content-Transfer-Encoding: quoted-printable' . PHP_EOL;
mail($address, $subject, $body, $headers);

?>