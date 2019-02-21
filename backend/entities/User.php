<?php
include_once __DIR__ . '\..\includes.php';

/**
 * Class User
 * @method static UserDao dao()
 */
class User extends Entity
{
    public $login, $password_hash, $password_salt, $user_group_id,
        $first_name, $last_name, $email, $phone;

    public function __construct($id = null, $login = null, $password_hash = null, $password_salt = null, $user_group_id = null,
                                $first_name = null, $last_name = null, $email = null, $phone = null)
    {
        $this->id = $id;
        $this->login = $login;
        $this->password_hash = $password_hash;
        $this->password_salt = $password_salt;
        $this->user_group_id = $user_group_id;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->email = $email;
        $this->phone = $phone;
    }

    /**
     * @param string $password
     * @param string $salt
     */
    public function set_password($password, $salt = null)
    {
        $salt = $salt ? $salt : md5((string)time());
        $this->password_salt = $salt;
        $this->password_hash = md5($password . $salt);
    }

    /**
     * @param string $password
     * @return bool
     */
    public function try_password($password)
    {
        return $this->password_salt
            && $this->password_hash
            && md5($password . $this->password_salt) === $this->password_hash;
    }
}
