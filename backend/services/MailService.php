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
                Logger::log(sprintf('Failed to send email to "%s"', $to), Logger::ERROR);
                return false;
            }
        } catch (Exception $e) {
            Logger::log($e->getMessage(), Logger::ERROR);
            return false;
        }
    }

    private static $template_vars = array();

    /**
     * @param string $filename
     * @param array $vars
     * @return string
     */
    public static function get_email_template($filename, $vars)
    {
        MailService::$template_vars = $vars;

        $var = function ($key) {
            return isset(MailService::$template_vars[$key]) ? MailService::$template_vars[$key] : '{{{{ EMPTY }}}}';
        };

        ob_start();
        include $filename;
        $result = ob_get_contents();
        ob_end_clean();

        return $result;
    }
}
