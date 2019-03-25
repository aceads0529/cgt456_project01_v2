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

    public static function logout()
    {
        SessionService::reset();
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
        if (!$user || !$password) {
            throw new ResponseException(new Response(false, 'Missing required fields'));
        }

        $dao = UserDao::get_instance();

        if ($dao->select_login($user->login)) {
            throw new ResponseException(new Response(false, 'Login already exists'));
        }

        $user->set_password($password);

        $success = $dao->insert($user);
        AuthService::login($user->login, $password);

        return $success;
    }

    /**
     * @param string $email
     * @param string $redirect_url
     * @return bool|int|string
     */
    public static function register_guest($email, $redirect_url)
    {
        $conn = DaoConnection::default_host();

        if ($conn->query('INSERT IGNORE INTO guest (email, redirect_url) VALUES (?, ?)', [$email, $redirect_url])) {
            return $conn->insert_id();
        } else {
            return false;
        }
    }

    /**
     * @param int $id
     * @param string $hash
     * @return bool|string
     */
    public static function guest_redirect($id, $hash)
    {
        $conn = DaoConnection::default_host();

        if (($rows = $conn->query('SELECT * FROM guest WHERE id = ?', [$id]))
            && sizeof($rows) > 0) {
            $rows = $rows[0];
            if (md5($rows['email']) == $hash) {
                SessionService::set('guest_id', $rows['id']);
                return $rows['redirect_url'];
            }
        }

        return false;
    }
}
