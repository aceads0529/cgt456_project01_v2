<?php

class Debug
{
    const INFO = 0, WARNING = 1, ERROR = 2;

    /**
     * @param string $message
     * @param int $code
     */
    public static function log($message, $code = Debug::INFO)
    {
        switch ($code) {
            case Debug::INFO:
                $code = 'INFO';
                break;
            case Debug::WARNING:
                $code = 'WARNING';
                break;
            case Debug::ERROR:
                $code = 'ERROR';
                break;
        }

        $message = sprintf('[%s] %s: %s' . PHP_EOL, $code, self::get_timestamp(), $message);
        $file = self::get_logfile();

        fwrite($file, $message);
        fclose($file);
    }

    public static function get_script_dir()
    {
        return basename(pathinfo($_SERVER['SCRIPT_FILENAME'], PATHINFO_DIRNAME));
    }

    /**
     * @return string
     */
    private static function get_timestamp()
    {
        return date(DATE_RFC1036, time());
    }

    private static function get_logfile()
    {
        return fopen($_SERVER['DOCUMENT_ROOT'] . '\log', 'a');
    }
}