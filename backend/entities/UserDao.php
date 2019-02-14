<?php
include_once __DIR__ . '\..\includes.php';

class UserDao extends EntityDao
{
    public function __construct()
    {
        parent::__construct('user', 'User');
    }

    public function get_advisor_students($advisor_id)
    {
        $query = (new DaoQuery(DaoQuery::SELECT))
            ->tables('user U', 'advisor_students A_S')
            ->columns('U.*')
            ->where(['A_S.advisor_id' => $advisor_id])
            ->where('U.id = A_S.student_id');

        $result = $this->conn->execute($query);

        if ($result) {
            foreach ($result as &$item) {
                $item = new User($item);
            }
        } else {
            $result = array();
        }

        return $result;
    }
}