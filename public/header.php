<?php include_once __DIR__ . '\includes.php'; ?>

<!DOCTYPE html>
<html lang="en-us">
<head>
    <base href="/"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login</title>
    <link href="./css/main.css" rel="stylesheet"/>
    <link href="./css/form-ui.css" rel="stylesheet"/>
	<link rel="shortcut icon" type="image/ico" href="https://www.purdue.edu/purdue/images/favicon.ico">
	<style> @import url("https://use.typekit.net/ile1hmn.css");</style>
	<!-- jQuery (uncompressed) -->
    <script src="https://code.jquery.com/jquery-3.3.1.js"
            integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
            crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
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
<div class="banner-holder">
	<img src="https://polytechnic.purdue.edu/sites/default/files/files/PPI-Polyt-V-W-RGB.png">
</div>	
<div class="header">
	<nav>
    	<ul>
        	<li><a href="auth/register.php">Register</a></li>
        	<li><a href="student/index.php">Student Portal</a></li>
    	</ul>
	</nav>
	
	<h1>Polytech Internship Program</h1>
	
	<?php if (!AuthService::get_active_user()): ?>
	<button id="loginBtn" style="display: none;"><a href="auth/logout.php">Logout</a></button>
    <?php else: ?>
	<button id="loginBtn"><a href="auth/logout.php">Logout</a></button>
	<?php endif; ?>
	
</div>

	
	

