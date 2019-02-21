<?php
include_once __DIR__ . '\..\includes.php';

$api = new RequestEndpoint();

$api->action('cgt-fields')
    ->callback(function ($request) {
        /** @var Request $request */

        return new Response(true, 'CGT fields found', OptionDao::get_instance()->get_cgt_fields());
    });

$api->call();