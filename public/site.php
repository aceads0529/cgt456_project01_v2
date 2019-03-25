<?php

const CGT_PAGE_DEFAULT = 'page-default';
const CGT_PAGE_FORM = 'page-form';
const CGT_PAGE_FORM_SM = 'page-form-sm';
const CGT_PAGE_FULL = 'page-full';

const CGT_USER_NONE = 0b0;
const CGT_USER_STUDENT = 0b1;
const CGT_USER_SUPERVISOR = 0b10;
const CGT_USER_ADVISOR = 0b100;
const CGT_USER_ADMIN = 0b1000;
const CGT_USER_ALL = 0b1111;

/**
 * @param string $title
 * @param string $page_type
 */
function site_header($title = '', $page_type = CGT_PAGE_DEFAULT)
{
    global $PAGE_TITLE, $PAGE_TYPE;

    $PAGE_TITLE = $title;
    $PAGE_TYPE = $page_type;

    include_once 'header.php';
}

/**
 * @param int $allowed_groups
 * @return User
 */
function auth_allow($allowed_groups)
{
    include_once 'includes.php';
    $user = AuthService::get_active_user();

    if ($allowed_groups == CGT_USER_NONE) {
        return $user;
    }

    if (!$user) {
        $exit = true;
    } else {

        switch ($user->user_group_id) {
            case 'admin':
                $user_group = CGT_USER_ADMIN;
                break;
            case 'advisor':
                $user_group = CGT_USER_ADVISOR;
                break;
            case 'student':
                $user_group = CGT_USER_STUDENT;
                break;
            default:
                $user_group = false;
        }

        $exit = !($user_group & $allowed_groups);
    }

    if ($exit) {
        header('Location: /auth/login.php');
        exit;
    } else {
        return $user;
    }
}
