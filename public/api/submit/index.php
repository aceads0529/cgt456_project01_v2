<?php
include_once __DIR__ . '\..\includes.php';

$api = new RequestEndpoint();

$api->action('search')
    ->requires('name')
    ->callback(function ($request) {
        /** @var Request $request */

        $dao = new EmployerDao;
        $employers = $dao->search($request->get_param('name'));

        return new Response(true, '', $employers);
    });

$api->action('session')
    ->requires('employerId', 'jobTitle', 'startDate', 'endDate', 'offsite', 'totalHours', 'payRate')
    ->callback(function ($request) {
        $user = AuthService::get_active_user_or_deny();

        $session = WorkSession::from_request($request);
        $session->student_id = $user->id;
        if (WorkSession::dao()->insert($session)) {
            return new Response('Work session created successfully', ['id' => $session->id]);
        } else {
            return new Response(false, 'Work session not created');
        }
    });

$api->call();