<?php
/* 
 * La onda de esto es simplificar el envío automático de mensajes
 * 
 * ---------------------------------------------------------------------*
 *
 *            DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
 *                    Version 2, December 2004
 *
 * Copyright (C) 2017 pwqw <no@email>
 *
 * Everyone is permitted to copy and distribute verbatim or modified
 * copies of this license document, and changing it is allowed as long
 * as the name is changed.
 *
 *            DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
 *   TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION
 *
 * 0. You just DO WHAT THE FUCK YOU WANT TO.
 */

include("../lib/class.smtp.php");
include("../lib/class.phpmailer.php");

class Sender
{
    public function get_response($POST) {

        $error_message = $this->validate($POST);

        if (strlen($error_message) > 2) {
            return $this->died($POST, $error_message, false);
        }

        //A partir de aqui se contruye el cuerpo del mensaje tal y como llegará al correo
        
        $html_message = $this->do_email_html_content($POST);
        $text_message = $this->do_email_text_content($POST);

        //Se envía el correo

        $from_email = $POST['email'];
        $from_name = $POST['name'];

        $sended = $this->send_email($html_message, $text_message, $from_email, $from_name);

        if ($sended) {

            return $this->died($POST, "Mensaje enviado correctamente. Me pondré en contacto cuanto antes.", true);

        } else {

            return $this->died($POST, "El mensaje no se pudo enviar.. :(", false, $sended);

        }
    }


    protected function validate($POST) {
        return '';
    }


    protected function died($new_POST, $message, $success, $details = "")
    {
        // si hay algún error, el formulario puede desplegar su mensaje de aviso

        $response = Array(

            'message' => $message,
            'success' => $success,
            'details' => $details,
        );

        $return = Array(

            'response' => $response,
            'new_post' => $new_POST
        );

        return $return;

    }


    protected function do_email_html_content($POST) {
        $name = $POST['name'];
        $contact = $POST['contact'];
        $message = $POST['message'];
        
        $email_content = "<div style=\"font-family: Helvetica,sans-serif; font-size: 14px\">

            <div style=\"margin: 15px\">
                <p style=\"display: inline; font-weight: bold;\">
                    ". $this->clean_string($name) ."
                </p>
                <p style=\"display: inline;\">
                    ( ". $this->clean_string($contact) ." ),
                </p>
            </div>
            <div style=\"margin: 15px;\">
                <p>". $this->clean_string($message) ."</p>
            </div>

        </div>";

        return $email_content;
    }

    protected function do_email_text_content($POST) {
        return '';
    }

    protected function clean_string($string)
    {

        $bad = array("content-type", "bcc:", "to:", "cc:", "href");

        return str_replace($bad, "", $string);

    }


    protected function send_email($html_message, $text_message, $from_email, $from_name) {

        // Edita las dos líneas siguientes con tu dirección de correo y asunto personalizados
        $email_to = "email@example.com";
        $email_subject = "Asunto del email";

        $mail = new PHPMailer;

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->CharSet = 'UTF-8';
        $mail->Host = 'smtp.example.com';                     // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'username@example.com';             // SMTP username
        $mail->Password = 'pass1234';                         // SMTP password
        $mail->Port = 587;
        $mail->SMTPSecure = 'tls';                            // Enable encryption, only 'tls' is accepted
        $mail->From = $from_email;
        $mail->FromName = $from_name;
        $mail->Subject = $email_subject;
//        $mail->Body    = $email_message;
        $mail->MsgHTML($html_message);

        $mail->addAddress($email_to);                 // Add a recipient

        $mail->WordWrap = 72;                         // Set word wrap to 50 characters

        if(!$mail->Send()) {
            return $mail->ErrorInfo;
        } else {
            return false;
        }
    }
}
