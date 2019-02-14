<?php

class SessionService
{
    /**
     * @param string $id
     * @return mixed
     */
    public static function get($id)
    {
        self::safe_session_start();
        $value = isset($_SESSION[$id]) ? $_SESSION[$id] : null;
        session_write_close();
        return $value;
    }

    /**
     * @param string $id
     * @param mixed $value
     */
    public static function set($id, $value)
    {
        self::safe_session_start();
        $_SESSION[$id] = $value;
        session_write_close();
    }

    private static function safe_session_start()
    {
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
    }
}