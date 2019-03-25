<?php
include_once __DIR__ . '\includes.php';
global $PAGE_TITLE;
global $PAGE_TYPE;
?>

<!DOCTYPE html>
<html lang="en-us">
<head>
    <base href="/"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        <?php
        $title_tag = SITE_TITLE;
        if ($PAGE_TITLE) {
            $title_tag .= ' - ' . $PAGE_TITLE;
        }
        echo $title_tag;
        ?>
    </title>

    <link href="./css/main.css" rel="stylesheet"/>
    <link href="./css/form-ui.css" rel="stylesheet"/>
    <link href="./css/login.css" rel="stylesheet"/>

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
    <script src="./scripts/form-ui/file-element.js"></script>
    <script src="./scripts/md5.min.js"></script>

    <script src="./scripts/api.js"></script>

    <!-- ag-grid -->
    <script src="https://unpkg.com/ag-grid-community@20.1.0/dist/ag-grid-community.min.js"></script>
</head>
<body>
<?php if ($PAGE_TYPE != CGT_PAGE_FULL): ?>
<header>
    <div id="header-content">
        <a id="header-logo" href="https://polytechnic.purdue.edu/"></a>
        <div id="header-banner"></div>
    </div>

    <nav>
        <div id="nav-content">
            <?php if ($user = AuthService::get_active_user()):
                $home_link = $user->user_group_id . '/index.php'; ?>

                <a href="<?php echo $home_link; ?>">Home</a>
                <?php if ($user->user_group_id === 'student'): ?>
                    <a href="form/student.php">Submit session</a>
                <?php endif; ?>
                <div id="nav-spacer"></div>
                <span><?php echo $user->first_name . ' ' . $user->last_name; ?></span>
                <a href="auth/logout.php">Logout</a>

            <?php else: ?>

                <a href="auth/login.php">Login</a>

            <?php endif; ?>
        </div>
    </nav>
</header>

<div id="page-content" class="<?php echo $PAGE_TYPE; ?>">
    <?php endif; ?>
