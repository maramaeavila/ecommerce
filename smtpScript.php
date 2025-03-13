<?php

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'smtpConfig.php';

if (isset($_POST["send"])) {

    /* Customer Acknowledgement Message */

    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = 'smtp.gmail.com';
    $mail->Username = 'avila.maramae.orbeta@gmail.com';
    $mail->Password = 'madq jemj tvvf pwpr';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    $mail->setFrom('avila.maramae.orbeta@gmail.com');
    $mail->addAddress($_POST["email"]);
    $mail->isHTML(false);
    $mail->Subject = 'Acknowledgement of Your Inquiry';
    $customerMessage = "Dear " . $_POST['name'] . ",\n\n";
    $customerMessage .= "Thank you for contacting us. We've received your message and are currently reviewing it. We'll get back to you shortly.\n\n";
    $customerMessage .= "Best regards,\nCasetify";

    $mail->Body = $customerMessage;

    /* Customer Message Received By Admin*/

    $adminMail = new PHPMailer(true);
    $adminMail->isSMTP();
    $adminMail->SMTPAuth = true;
    $adminMail->Host = 'smtp.gmail.com';
    $adminMail->Username = 'avila.maramae.orbeta@gmail.com';
    $adminMail->Password = 'madq jemj tvvf pwpr';
    $adminMail->SMTPSecure = 'ssl';
    $adminMail->Port = 465;

    $adminMail->setFrom($_POST["email"]);
    $adminMail->addAddress('avila.maramae.orbeta@gmail.com');
    $adminMail->isHTML(false);
    $adminMail->Subject = 'Customer Contact Us Messages';
    $adminMail->Body = $_POST["message"];



    if ($mail->send() && $adminMail->send()) {
        echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                window.onload = function() {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Message sent successfully.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = 'contactus.php';
                    });
                }
            </script>
        ";
    } else {
        echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                window.onload = function() {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Message failed to send. Please try again.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = 'contactus.php';
                    });
                }
            </script>
        ";
    }
}
