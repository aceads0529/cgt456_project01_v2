<?php
include_once __DIR__ . '\..\includes.php';

$api = new RequestEndpoint;

$api->action('login')
    ->requires('login', 'password')
    ->callback(function ($request) {
        /** @var Request $request */

        $login = $request->get_data('login');
        $password = $request->get_data('password');

        if (AuthService::login($login, $password)) {
            return new Response(true, 'Login successful');
        } else {
            return new Response(false, 'Username and password don\'t match');
        }
    });

$api->action('logout', function ($request) {
    return new Response(true, 'Logout successful');
});

$api->action('register')
    ->requires('login', 'password', 'userGroupId', 'firstName', 'lastName', 'email')
    ->callback(function ($request) {
        /** @var Request $request */
        $user = User::from_request($request);
        $success = AuthService::register($user, $request->get_data('password'));
        return $success
            ? new Response(true, 'User successfully registered')
            : new Response(false, 'User not registered');
    });

$api->action('select', function ($request) {
    /** @var Request $request */

    $user = AuthService::get_active_user_or_deny();

    $query = User::from_request($request);
    $user->get_constraints()->filter($query);

    $results = User::dao()->select($query);
    return new Response(true, 'Users selected', $results);
});

$api->action('active', function ($request) {
    /** @var Request $request */
    if ($user = AuthService::get_active_user()) {
        return new Response(true, 'Active user found', $user->to_response_array());
    } else {
        return new Response(false, 'No active user');
    }
});

$api->call();
