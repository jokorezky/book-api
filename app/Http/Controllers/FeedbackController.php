<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class FeedbackController extends Controller
{
    public function index(Request $request)
    {
        $subject = "Contact dari " . $request->input('name');
        $name = $request->input('name');
        $emailAddress = $request->input('contactEmail');
        $message = $request->input('message');

        $mail = new PHPMailer(true);
        try {
            $mail->SMTPDebug = 2;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'redaksi.globalkepri@gmail.com';
            $mail->Password = 'alyaqueen123#';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 587;
            $mail->setFrom("redaksi.globalkepri@gmail.com", "Redaksi");
            $mail->addAddress('jokorezky@gmail.com', 'Halo');
            $mail->addReplyTo($emailAddress, $name);


            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $message;
            $mail->AltBody = $message;

            $mail->send();

            $request->session()->flash('status', 'Terima kasih, kami sudah menerima email anda.');
            return response()->json($request->all(), 201);

        } catch (Exception $e) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    }
}
