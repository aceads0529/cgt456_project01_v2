<!DOCTYPE html>
<html lang="en-us">
<head>
    <base href="/"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login</title>
    <link href="./css/main.css" rel="stylesheet"/>
    <link href="./css/form-ui.css" rel="stylesheet"/>

    <!-- jQuery (uncompressed) -->
    <script src="https://code.jquery.com/jquery-3.3.1.js"
            integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
            crossorigin="anonymous"></script>

    <!-- jQuery (minified)
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script> -->

    <script src="./scripts/form-ui/element.js"></script>
    <script src="./scripts/form-ui/group-element.js"></script>
    <script src="./scripts/form-ui/text-element.js"></script>
    <script src="scripts/form-ui/option-element.js"></script>
    <script src="./scripts/form-ui/button-element.js"></script>
    <script src="./scripts/form-ui/row-element.js"></script>
    <script src="./scripts/form-ui/readonly-element.js"></script>
    <script src="./scripts/form-ui/search-element.js"></script>

    <script src="./scripts/api.js"></script>
</head>
<body>

<h1>Polytech Internship Program</h1>

<nav>
    <ul>
        <li><a href="auth/login.php">Login</a></li>
        <li><a href="auth/register.php">Register</a></li>
    </ul>
</nav>

<?php include_once __DIR__ . '\..\backend\includes.php'; ?>