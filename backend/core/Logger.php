<?php

class Logger
{
    const INFO = 0, WARNING = 1, ERROR = 2;

    /**
     * @param string $message
     * @param int $code
     */
    public static function log($message, $code = Logger::INFO)
    {
        switch ($code) {
            case Logger::INFO:
                $code = 'INFO';
                break;
            case Logger::WARNING:
                $code = 'WARNING';
                break;
            case Logger::ERROR:
                $code = 'ERROR';
                break;
        }

        $message = sprintf('[%s] %s: %s' . PHP_EOL, $code, self::get_timestamp(), $message);
        $file = self::get_logfile();

        fwrite($file, $message);
        fclose($file);
    }

    /**
     * @param string $message
     */
    public static function error($message)
    {
        self::log($message, Logger::ERROR);
    }

    /**
     * @param string $message
     */
    public static function warning($message)
    {
        self::log($message, Logger::WARNING);
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

    /**
     * @return bool|resource
     */
    private static function get_logfile()
    {
        return fopen($_SERVER['DOCUMENT_ROOT'] . '\log', 'a');
    }
}
