<?php /** @var callable $var */ ?>

<div style="max-width: 600px">
    <h1>Intern Evaluation</h1>
    <p>Hello! A Purdue intern has recently submitted an internship application, designating you as their supervisor
        at <?php echo $var('company_name'); ?>. We invite you to fill out this survey, providing the Purdue CGT
        Department
        information about our students' performance.</p>
    <p>To complete the survey, please visit this link:
        <a href="<?php echo $var('invitation_url'); ?>">Purdue University CGT Internship Survey Link</a>
    </p>
</div>
