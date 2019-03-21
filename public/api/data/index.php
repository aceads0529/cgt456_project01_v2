<?php
include_once __DIR__ . '\..\..\includes.php';

$api = new RequestEndpoint;

$api->action('sessions')
    ->callback(function ($request) {
        /** @var Request $request */

        $id = filter_var($request->get_data('id'), FILTER_VALIDATE_INT);
        $conn = DaoConnection::default_host();

        $query_str =
            'SELECT U.first_name, U.last_name, E.name as employer, W.id as session_id, W.job_title, W.start_date, W.end_date, W.total_hours, W.pay_rate, W.approved ' .
            'FROM user U, employer E, work_session W ' .
            'WHERE W.student_id = U.id AND W.employer_id = E.id';

        $params = array();

        if ($id) {
            $query_str .= ' AND U.id = :id';
            $params['id'] = $id;
        }

        $stmt = $conn->pdo_execute($query_str, $params);
        $sessions = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $row['approved'] = (bool)$row['approved'];
            $sessions[] = [
                'fullName' => $row['first_name'] . ' ' . $row['last_name'],
                'firstName' => $row['first_name'],
                'lastName' => $row['last_name'],
                'employer' => $row['employer'],
                'session' => [
                    'id' => $row['session_id'],
                    'approved' => (bool)$row['approved']
                ],
                'jobTitle' => $row['job_title'],
                'startDate' => $row['start_date'],
                'endDate' => $row['end_date'],
                'totalHours' => $row['total_hours'],
                'payRate' => $row['pay_rate']
            ];
        }

        return new Response(true, '', $sessions);
    });

$api->action('form-student')
    ->requires('sessionId')
    ->callback(function ($request) {
        /** @var Request $request */

        $id = filter_var($request->get_data('sessionId'), FILTER_VALIDATE_INT);

        $conn = DaoConnection::default_host();


        $form = $conn->pdo_execute(
            'SELECT F.*, S.*, E.* FROM form_student F, work_session S, Employer E WHERE S.id = :id AND F.work_session_id = S.id AND S.employer_id = E.id',
            ['id' => $id]);

        return new Response(true, '', $form);
    });

$api->call();
