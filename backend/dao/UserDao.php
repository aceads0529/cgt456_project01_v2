<?php
include_once __DIR__ . '\..\includes.php';

class UserDao extends EntityDao
{
    protected static $instance;

    /**
     * @return UserDao
     */
    public static function get_instance()
    {
        /** @var UserDao $instance */
        $instance = parent::get_instance();
        return $instance;
    }

    /**
     * @param int[]|string[] $ids
     * @return Entity[]|bool
     */
    public function select(...$ids)
    {
        if ($rows = $this->conn->query('SELECT * FROM user WHERE ' . $this->where('id', $ids), $ids)) {
            $result = array();
            foreach ($rows as $row) {
                $result[] = User::from_array($row);
            }
            return $result;
        } else {
            return false;
        }
    }

    /**
     * @param User $entity
     * @return bool
     */
    public function insert(&$entity)
    {
        return $this->conn->query(
            'INSERT INTO user (user_group_id, login, password_hash, password_salt, first_name, last_name, email, phone) VALUES (?, ?, ?, ?, ?, ?, ?, ?)', [
            $entity->user_group_id, $entity->login, $entity->password_hash, $entity->password_salt,
            $entity->first_name, $entity->last_name, $entity->email, $entity->phone
        ]);
    }

    /**
     * @param Entity $entity
     * @return bool
     */
    public function update($entity)
    {
        $values = $entity->to_array();
        unset($values['id']);

        $query_str = 'UPDATE user SET ' . $this->set($values) . ' WHERE id = ?';

        $values = array_values($values);
        $values[] = $entity->id;

        return $this->conn->query($query_str, $values);
    }

    /**
     * @param int[]|string[] $ids
     * @return bool
     */
    public function delete(...$ids)
    {
        return $this->conn->query('DELETE FROM user WHERE ' . $this->where('id', $ids), $ids);
    }

    /**
     * @param $login
     * @return User|bool
     */
    public function select_login($login)
    {
        if (($rows = $this->conn->query('SELECT * FROM user WHERE login = ?', [$login]))
            && sizeof($rows) > 0) {
            return User::from_array($rows[0]);
        } else {
            return false;
        }
    }
}
