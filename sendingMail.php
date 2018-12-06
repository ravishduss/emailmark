<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

class sendingMail
{

    public $mail;

    public $message;

    public function __construct()
    {


    }



    public function sendMail($recipientEmail, $recipientName, $subject, $body, $altbody)
    {
        try {
            echo 'Inside';
            $mail = new PHPMailer(true);
            //Server settings
            $mail->SMTPDebug = 4;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'ravishdussaruth@gmail.com';                 // SMTP username
            $mail->Password = 'sookdeoboyz';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to
        
            //Recipients
            $mail->setFrom('ravishdussaruth@gmail.com', 'Ravish');
            $mail->addAddress($recipientEmail, $recipientName);     // Add a recipient
           
            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body = $body;
            $mail->AltBody = $altbody;

            $mail->send();

           return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function getItem(){
        return $this->message;
    }
   
}


?>