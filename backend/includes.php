<?php

include_once __DIR__ . '\core\Debug.php';
include_once __DIR__ . '\core\data\Dao.php';
include_once __DIR__ . '\core\data\DaoConnection.php';
include_once __DIR__ . '\core\data\Entity.php';
include_once __DIR__ . '\core\data\EntityDao.php';

include_once __DIR__ . '\core\http\Request.php';
include_once __DIR__ . '\core\http\RequestAction.php';
include_once __DIR__ . '\core\http\RequestEndpoint.php';
include_once __DIR__ . '\core\http\RequestPermissions.php';
include_once __DIR__ . '\core\http\Response.php';
include_once __DIR__ . '\core\http\ResponseException.php';

include_once __DIR__ . '\dao\EmployerDao.php';
include_once __DIR__ . '\dao\OptionDao.php';
include_once __DIR__ . '\dao\StudentFormDao.php';
include_once __DIR__ . '\dao\UserDao.php';
include_once __DIR__ . '\dao\WorkSessionDao.php';

include_once __DIR__ . '\entities\Employer.php';
include_once __DIR__ . '\entities\FormStudent.php';
include_once __DIR__ . '\entities\StudentForm.php';
include_once __DIR__ . '\entities\User.php';
include_once __DIR__ . '\entities\WorkSession.php';

include_once __DIR__ . '\lib\PHP Mailer\Exception.php';
include_once __DIR__ . '\lib\PHP Mailer\OAuth.php';
include_once __DIR__ . '\lib\PHP Mailer\PHPMailer.php';
include_once __DIR__ . '\lib\PHP Mailer\POP3.php';
include_once __DIR__ . '\lib\PHP Mailer\SMTP.php';

include_once __DIR__ . '\services\AuthService.php';
include_once __DIR__ . '\services\MailService.php';
include_once __DIR__ . '\services\SessionService.php';

