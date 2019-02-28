<?php include '.\..\header.php';
require_login(); ?>

<div class="ribbon">
    <img src="../images/Ribbon-01.png">
</div>

<div class="progress-wrapper">
    <ul id="progressbar">
        <li id="0" class="active">Employer</li>
        <li id="1">Work Session</li>
        <li id="2">Questionnaire</li>
    </ul>
</div>

<form id="form-student"></form>
<script src="../scripts/form-student.js"></script>

<?php include '.\..\footer.php'; ?>

