<?php

use PHPMailer\PHPMailer\PHPMailer;

include_once __DIR__ . '\..\includes.php';

class MailService
{
    private static $sender = 'Purdue University CGT Department';

    private static $username = 'aceads0529@gmail.com';
    private static $password = 'bkkkbldiiioxlpre';

    /**
     * @param string $to
     * @param string $subject
     * @param string $body
     * @return bool
     */
    public static function email($to, $subject, $body)
    {
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->SMTPDebug = 2;
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = MailService::$username;
        $mail->Password = MailService::$password;
        $mail->SMTPSecure = 'tls';

        $mail->From = MailService::$username;
        $mail->FromName = MailService::$sender;
        $mail->addAddress($to);

        $mail->WordWrap = 50;

        $mail->Subject = $subject;

        $mail->isHTML(true);
        $mail->Body = $body;

        try {
            if ($mail->send()) {
                return true;
            } else {
                Debug::log(sprintf('Failed to send email to "%s"', $to), Debug::ERROR);
                return false;
            }
        } catch (Exception $e) {
            Debug::log($e->getMessage(), Debug::ERROR);
        }
    }
}
