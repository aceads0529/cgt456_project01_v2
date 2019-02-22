<?php
include_once __DIR__ . '\..\..\includes.php';

$api = new RequestEndpoint();

$api->action('employer')
    ->requires('search')
    ->callback(function ($request) {
        /** @var Request $request */

        $dao = new EmployerDao;
        $employers = $dao->search($request->get_data('search'));

        return new Response(true, '', $employers);
    });

$api->call();
