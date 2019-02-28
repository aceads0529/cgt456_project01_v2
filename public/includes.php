<?php include_once __DIR__ . '\..\backend\includes.php';

/**
 * @return User
 */
function require_login()
{
    if ($user = AuthService::get_active_user()) {
        return $user;
    } else {
        SessionService::set('auth_redirect', $_SERVER['SCRIPT_NAME']);
        header('Location: ../auth/login.php');
        exit;
    }
}
