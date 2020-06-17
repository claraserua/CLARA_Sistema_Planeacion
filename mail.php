<?php
require 'libs/PHPMailer/PHPMailerAutoload.php';

$mail = new PHPMailer;

//$mail->SMTPDebug  = 2;
$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.office365.com';  // Specify main and backup server
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'planeacion@redanahuac.mx';                            // SMTP username
$mail->Password = 'Pl@neaci0n';                           // SMTP password
$mail->SMTPSecure = 'tls';
$mail->Port = '587';                            // Enable encryption, 'ssl' also accepted

$mail->From = 'planeacion@redanahuac.mx';
$mail->FromName = 'Sistema de Planeación Estratégica';
$mail->addAddress('soycharly@live.com', 'Carlos');  // Add a recipient
$mail->addAddress('jose.ruiz@redanahuac.mx');               // Name is optional
$mail->addReplyTo('jose.ruiz@redanahuac.mx', 'Information');
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');

$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Here is the subject';
$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
   echo 'Message could not be sent.';
   echo 'Mailer Error: ' . $mail->ErrorInfo;
   exit;
}

echo 'Message has been sent';
?>