<?php
include_once __DIR__ . '\..\..\includes.php';

$api = new RequestEndpoint();

$api->action('form')
    ->requires('sessionId', 'prompts')
    ->callback(function ($request) {
        /** @var Request $request */

        $guest_id = SessionService::get('guest_id');
        $session = WorkSessionDao::get_instance()->select($request->get_data('sessionId'))[0];

        if (!$guest_id || $session->supervisor_id !== $guest_id) {
            return Response::error_permission();
        }

        $prompts = $request->get_data('prompts');

        $form = new SupervisorForm(
            $session->id,
            $guest_id,
            $prompts['dependable'] ? (int)$prompts['dependable'] : null,
            $prompts['cooperative'] ? (int)$prompts['cooperative'] : null,
            $prompts['interested'] ? (int)$prompts['interested'] : null,
            $prompts['fastLearner'] ? (int)$prompts['fastLearner'] : null,
            $prompts['initiative'] ? (int)$prompts['initiative'] : null,
            $prompts['workQuality'] ? (int)$prompts['workQuality'] : null,
            $prompts['responsibility'] ? (int)$prompts['responsibility'] : null,
            $prompts['criticism'] ? (int)$prompts['criticism'] : null,
            $prompts['organization'] ? (int)$prompts['organization'] : null,
            $prompts['techKnowledge'] ? (int)$prompts['techKnowledge'] : null,
            $prompts['judgement'] ? (int)$prompts['judgement'] : null,
            $prompts['creativity'] ? (int)$prompts['creativity'] : null,
            $prompts['problemAnalysis'] ? (int)$prompts['problemAnalysis'] : null,
            $prompts['selfReliance'] ? (int)$prompts['selfReliance'] : null,
            $prompts['communication'] ? (int)$prompts['communication'] : null,
            $prompts['writing'] ? (int)$prompts['writing'] : null,
            $prompts['profAttitude'] ? (int)$prompts['profAttitude'] : null,
            $prompts['profAppearance'] ? (int)$prompts['profAppearance'] : null,
            $prompts['punctuality'] ? (int)$prompts['punctuality'] : null,
            $prompts['timeEffective'] ? (int)$prompts['timeEffective'] : null);

        if (SupervisorFormDao::get_instance()->insert($form)) {
            return new Response(true, 'Form created successfully');
        } else {
            return Response::error_server();
        }
    });

$api->action('form-approve')
    ->requires('sessionId')
    ->callback(function ($request) {
        /** @var Request $request */

        WorkSessionDao::get_instance()->update(WorkSession::from_array(['id' => (int)$request->get_data('sessionId'), 'approved' => 1]));
        return new Response(true, 'Form approved successfully');
    });

$api->call();
