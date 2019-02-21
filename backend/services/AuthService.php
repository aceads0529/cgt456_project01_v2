<?php
include_once __DIR__ . '\..\includes.php';

class AuthService
{
    /**
     * @param string $login
     * @param string $password
     * @return bool
     */
    public static function login($login, $password)
    {
        if ($user = UserDao::get_instance()->select_login($login)) {
            if ($user->try_password($password)) {
                self::set_active_user($user);
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * @return User
     */
    public static function get_active_user()
    {
        return SessionService::get('auth_active_user');
    }

    /**
     * @return User
     * @throws ResponseException
     */
    public static function get_active_user_or_deny()
    {
        if ($user = SessionService::get('auth_active_user')) {
            return $user;
        } else {
            throw new ResponseException(Response::error_permission());
        }
    }

    /**
     * @param User $user
     */
    public static function set_active_user($user)
    {
        SessionService::set('auth_active_user', $user);
    }

    /**
     * @param User $user
     */
    public static function get_user_permissions($user)
    {
        $group = $user !== null ? $user->user_group_id : null;

        switch ($group) {
            case 'admin':
        }
    }

    /**
     * @param User $user
     * @param string $password
     * @return bool
     * @throws ResponseException
     */
    public static function register($user, $password)
    {
        $dao = UserDao::get_instance();

        if ($dao->select_login($user->login)) {
            throw new ResponseException(new Response(false, 'Login already exists'));
        }

        $user->set_password($password);

        $success = $dao->insert($user);
        AuthService::login($user->login, $password);

        return $success;
    }
}
