
<?php
//ESTE ARQUIVO DEVE FICAR EM /usr/share/php/

require 'PHPMailer/PHPMailerAutoload.php';

$mail = new PHPMailer;
$mail->CharSet = 'UTF-8';

//$mail->SMTPDebug = 3;                               // Enable verbose debug output
$mail->isSMTP();
$mail->Host = 'mail.esportes.co';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'contato@esportes.co';                 // SMTP username
$mail->Password = 'k1llerec';                           // SMTP password
$mail->SMTPSecure = '';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 26;                                    // TCP port to connect to

$mail->setFrom('contato@esportes.co', 'Contato');
$mail->addReplyTo('contato@esportes.co', 'Contato');

$mail->isHTML(true);                                  // Set email format to HTML

//$mail->Subject = 'Here is the subject';
//$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

$mail->addBCC('contato@esportes.co', 'Emanuel Piza');     // Add a recipient