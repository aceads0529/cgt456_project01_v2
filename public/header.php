<?php include_once __DIR__ . '\includes.php'; ?>

<!DOCTYPE html>
<html lang="en-us">
<head>
    <base href="/"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Purdue University CGT Internship Portal</title>

    <link href="./css/main.css" rel="stylesheet"/>
    <link href="./css/form-ui.css" rel="stylesheet"/>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700|Open+Sans:400,400i,700"
          rel="stylesheet">

    <link rel="shortcut icon" type="image/ico" href="https://www.purdue.edu/purdue/images/favicon.ico">
    <style> @import url("https://use.typekit.net/ile1hmn.css");</style>

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
    <script src="./scripts/md5.min.js"></script>

    <script src="./scripts/api.js"></script>
</head>
<body>
<div class="header">
    <?php
    $user = AuthService::get_active_user();
    $user_group = null;

    if ($user) {
        $user_group = $user->user_group_id;
    }

    $home_link = null;

    switch ($user_group) {
        case 'student':
            $home_link = 'student/index.php';
            break;
        case 'advisor':
            $home_link = 'advisor/index.php';
    }
    ?>

    <div>
        <img id="logo" src="https://polytechnic.purdue.edu/sites/default/files/files/PPI-Polyt-V-W-RGB.png">

        <div id="polytechHeader">
            <h1>Polytech Internship Program</h1>
        </div>
    </div>

    <nav>
        <ul>
            <?php if ($home_link !== null): ?>
                <li><a href="<?php echo $home_link; ?>">Home</a></li>
            <?php endif; ?>
            <li><a href="auth/register.php">Register</a></li>
        </ul>
    </nav>



    <?php if (!AuthService::get_active_user()): ?>
        <button id="loginBtn" style="display: none;"><a href="auth/logout.php">Logout</a></button>
    <?php else: ?>
        <button id="loginBtn"><a href="auth/logout.php">Logout</a></button>
    <?php endif; ?>

</div>

	
	

