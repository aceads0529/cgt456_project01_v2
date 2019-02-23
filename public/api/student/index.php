<?php
include_once __DIR__ . '\..\..\includes.php';

$api = new RequestEndpoint();

$api->action('form-get')
    ->requires('workSessionId')
    ->callback(function ($request) {
        /** @var Request $request */

        $user = AuthService::get_active_user_or_deny();

        if (($session = WorkSessionDao::get_instance()->select($request->get_data('workSessionId')))
            && sizeof($session) > 0) {

            $session = $session[0];

            if ($session->student_id !== $user->id)
                return Response::error_permission();

            $employer = EmployerDao::get_instance()->select($session->employer_id)[0];
            $prompts = StudentFormDao::get_instance()->select_form($session->id, $user->id);

            return new Response(true, 'Form values retrieved', ['employer' => $employer, 'session' => $session, 'prompts' => $prompts]);
        } else {
            return new Response(false, 'Session not found');
        }
    });

$api->action('form-delete')
    ->requires('workSessionId')
    ->callback(function ($request) {
        /** @var Request $request */

        $user = AuthService::get_active_user_or_deny();
        if (($session = WorkSessionDao::get_instance()->select($request->get_data('workSessionId')))
            && sizeof($session) > 0) {
            $session = $session[0];

            if ($session->student_id !== $user->id) {
                return Response::error_permission();
            }

            return WorkSessionDao::get_instance()->delete($session->id)
            && StudentFormDao::get_instance()->delete($session->id)
                ? new Response(true, 'Session deleted')
                : new Response(false, 'Session not deleted');

        }
    });

$api->action('form')
    ->requires('employer', 'session', 'prompts')
    ->callback(function ($request) {
        /** @var Request $request */

        $user = AuthService::get_active_user_or_deny();
        $employer = $request->get_data('employer');

        $employer = new Employer(
            $employer['id'] ? (int)$employer['id'] : null,
            $employer['name'],
            $employer['address'],
            $employer['cgtFields']);

        if ($employer->id === null) {
            EmployerDao::get_instance()->insert($employer);
        }

        $session = $request->get_data('session');
        $prompts = $request->get_data('prompts');

        $session = new WorkSession(
            $session['id'] !== null && $session['id'] !== '' ? (int)$session['id'] : null,
            $user->id,
            null,
            $employer->id,
            $session['jobTitle'],
            $session['address'],
            $session['startDate'],
            $session['endDate'],
            (int)$prompts['offsite'],
            (int)$session['compensation']['totalHours'],
            (float)$session['compensation']['payRate']);

        if ($session->id === null) {
            WorkSessionDao::get_instance()->insert($session);
        } else {
            WorkSessionDao::get_instance()->update($session);
        }

        $prompts = new StudentForm(
            $session->id,
            $user->id,
            $prompts['rating'] !== null ? (int)$prompts['rating'] : null,
            $prompts['activities'],
            $prompts['relevantWork'],
            $prompts['difficulties'],
            $prompts['relatedToMajor'],
            $prompts['wantedToLearn'],
            $prompts['cgtChangedMind'],
            $prompts['providedContacts']);

        if (StudentFormDao::get_instance()->exists($prompts->work_session_id, $prompts->student_id)) {
            StudentFormDao::get_instance()->update($prompts);
        } else {
            StudentFormDao::get_instance()->insert($prompts);
        }

        $guest_email = $request->get_data('employer')['email'];
        $guest_id = AuthService::register_guest($guest_email, '/auth/login.php');

        MailService::email($guest_email, 'Supervisor Survey', 'Please take the time to fill out this survey: <a href="p1.cgt456.localhost/invite.php?id=' . $guest_id . '">Purdue Polytech Internship Program</a>"');

        return new Response(true, 'Form submitted successfully');
    });

$api->call();
