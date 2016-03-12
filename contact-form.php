<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once 'phpmailer/class.phpmailer.php';

if (isset($_POST['inputName']) && isset($_POST['inputEmail']) && isset($_POST['inputSubject']) && isset($_POST['inputMessage'])) {

    //check if any of the inputs are empty
    if (empty($_POST['inputName']) || empty($_POST['inputEmail']) || empty($_POST['inputSubject']) || empty($_POST['inputMessage'])) {
        $data = array('success' => false, 'message' => 'Please fill out the form completely.');
        echo json_encode($data);
        exit;
    }

    //create an instance of PHPMailer
    // $mail = new PHPMailer();

    // $mail->From = $_POST['inputEmail'];
    // $mail->FromName = $_POST['inputName'];
    // $mail->AddAddress('fajarbukhaeri08@gmail.com'); //recipient 
    // $mail->Subject = $_POST['inputSubject'];
    // $mail->Body = "Name: " . $_POST['inputName'] . "\r\n\r\nMessage: " . stripslashes($_POST['inputMessage']);

    $email = stripslashes(strip_tags($_POST['inputEmail']));

    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "tls";
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 587;
    $mail->Username = "fajarbukhaeri08@gmail.com";
    $mail->Password = "08041994";
    $mail->SetFrom('fajarbukhaeri08@gmail.com','De Yo');
    $mail->FromName = "Fajar";
    $mail->AddAddress($email);
    $mail->Subject = "Prueba con PHPMailer";
    $mail->Body = "<H3>Bienvenido! Esto Funciona!</H3>";
    $mail->IsHTML (true);
    $mail->Send();

    if (isset($_POST['ref'])) {
        $mail->Body .= "\r\n\r\nRef: " . $_POST['ref'];
    }

    if(!$mail->send()) {
        $data = array('success' => false, 'message' => 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo);
        echo json_encode($data);
        exit;
    }

    $data = array('success' => true, 'message' => 'Thanks! We have received your message.');
    echo json_encode($data);

} else {

    $data = array('success' => false, 'message' => 'Please fill out the form completely.');
    echo json_encode($data);

}