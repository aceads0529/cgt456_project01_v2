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
        if ($user = User::dao()->select_by('login', $login)) {
            /** @var User $user */
            $user = $user[0];

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
     * @param User $user
     */
    public static function set_active_user($user)
    {
        SessionService::set('auth_active_user', $user);
    }

    /**
     * @param User $user
     * @param string $password
     * @return bool
     * @throws ResponseException
     */
    public static function register($user, $password)
    {
        $dao = UserGroup::dao();

        if (!$dao->select_by('id', $user->user_group_id))
            throw new ResponseException(new Response(false, 'User group doesn\'t exist'));

        $dao = User::dao();

        if ($dao->select_by('login', $user->login))
            throw new ResponseException(new Response(false, 'Login already exists'));

        $user->set_password($password);
        return $dao->insert($user);
    }
}