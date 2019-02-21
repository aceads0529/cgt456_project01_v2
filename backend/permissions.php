<?php
include_once __DIR__ . '\core\http\RequestPermissions.php';

$admin = new RequestPermissions('*');
$advisor = new RequestPermissions('*');

$student = new RequestPermissions();

$none = new RequestPermissions(
    'user/login',
    'user/register');