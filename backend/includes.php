<?php

include_once __DIR__ . '\core\Debug.php';
include_once __DIR__ . '\core\data\DaoConnection.php';
include_once __DIR__ . '\core\data\DaoQuery.php';
include_once __DIR__ . '\core\data\Entity.php';
include_once __DIR__ . '\core\data\EntityConstraint.php';
include_once __DIR__ . '\core\data\EntityConstraintGroup.php';
include_once __DIR__ . '\core\data\EntityDao.php';

include_once __DIR__ . '\core\http\Request.php';
include_once __DIR__ . '\core\http\RequestAction.php';
include_once __DIR__ . '\core\http\RequestEndpoint.php';
include_once __DIR__ . '\core\http\RequestPermissions.php';
include_once __DIR__ . '\core\http\Response.php';
include_once __DIR__ . '\core\http\ResponseException.php';

include_once __DIR__ . '\dao\EmployerDao.php';
include_once __DIR__ . '\dao\OptionDao.php';
include_once __DIR__ . '\dao\UserDao.php';

include_once __DIR__ . '\entities\Employer.php';
include_once __DIR__ . '\entities\Form.php';
include_once __DIR__ . '\entities\FormStudent.php';
include_once __DIR__ . '\entities\User.php';
include_once __DIR__ . '\entities\UserConstraints.php';
include_once __DIR__ . '\entities\UserGroup.php';
include_once __DIR__ . '\entities\WorkSession.php';

include_once __DIR__ . '\services\AuthService.php';
include_once __DIR__ . '\services\EmployerService.php';
include_once __DIR__ . '\services\SessionService.php';
include_once __DIR__ . '\services\StudentFormService.php';

xdebug_start_code_coverage();
