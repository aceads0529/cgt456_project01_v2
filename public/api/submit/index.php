<?php
include_once __DIR__ . '\..\includes.php';

$api = new RequestEndpoint();

$api->action('employer')
    ->requires('name', 'address', 'cgtFieldIds')
    ->callback(function ($request) {
        /** @var Request $request */

        $dao = Employer::dao();

        if ($existing = $dao->find_by_name($request->get_param('name'))) {
            $dao->update_cgt_fields($existing->id, $request->get_param('cgtFields'));
            return new Response(true, 'Employer already exists', ['id' => $existing->id]);
        } elseif ($dao->insert($employer = Employer::from_request($request))) {
            return new Response(true, 'Employer created successfully', ['id' => $employer->id]);
        } else {
            return new Response(false, 'Employer not created');
        }
    });

$api->action('session')
    ->requires('employerId', 'jobTitle', 'startDate', 'endDate', 'offsite', 'totalHours', 'payRate')
    ->callback(function ($request) {
        if ($user = AuthService::get_active_user()) {
            $session = WorkSession::from_request($request);
            $session->student_id = $user->id;
            if (WorkSession::dao()->insert($session)) {
                return new Response('Work session created successfully',['id'=>$session->id]);
            }
        } else {
            return Response::error_permission();
        }
    });

$api->call();