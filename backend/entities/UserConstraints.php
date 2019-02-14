<?php
include_once __DIR__ . '\..\includes.php';

class UserConstraints
{
    public function __construct()
    {
    }

    /**
     * @param User $user
     * @return EntityConstraintGroup
     */
    public static function create_from($user)
    {
        switch ($user->user_group_id) {
            case 'admin':
                return self::create_from_admin($user);
            case 'advisor':
                return self::create_from_advisor($user);
            case 'student':
                return self::create_from_student($user);
            default:
                return self::create_from_none();
        }
    }

    /**
     * @param User $user
     * @return EntityConstraintGroup
     */
    private static function create_from_admin($user)
    {
        $group = new EntityConstraintGroup();
        return $group;
    }

    /**
     * @param User $user
     * @return EntityConstraintGroup
     */
    private static function create_from_advisor($user)
    {
        $group = new EntityConstraintGroup();

        $user_ids = User::dao()->get_advisor_students($user->id);
        $user_ids = array_map(function ($f) {
            return $f->id;
        }, $user_ids);

        $group->field('* (User::id)', $user_ids);
        return $group;
    }

    /**
     * @param User $user
     * @return EntityConstraintGroup
     */
    private static function create_from_student($user)
    {
        $group = new EntityConstraintGroup();
        $group->field('*', []);
        return $group;
    }

    /**
     * @return EntityConstraintGroup
     */
    private static function create_from_none()
    {
        $group = new EntityConstraintGroup();
        $group->field('*', []);
        return $group;
    }
}