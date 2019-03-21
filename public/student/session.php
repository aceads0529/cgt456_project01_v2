<?php include '.\..\site.php';
site_header('Student Work Session', CGT_PAGE_FORM);

$user = require_login();

$sid = read_get('sid');

if (!$sid) {
    redirect('index.php');
}

$sid = (int)$sid;
$session = WorkSessionDao::get_instance()->select($sid)[0];

$form = StudentFormDao::get_instance()->select_form($sid, $session->student_id);

$student = UserDao::get_instance()->select($session->student_id)[0];

$employer = EmployerDao::get_instance()->select($session->employer_id)[0];

$cgt_fields = OptionDao::get_instance()->get_cgt_fields();
$cgt_fields = array_filter($cgt_fields, function ($el) {
    global $employer;
    return in_array($el['id'], $employer->cgt_field_ids);
});
$cgt_fields = array_map(function ($el) {
    return $el['label'];
}, $cgt_fields);


if (!$form) {
    redirect('index.php');
}

function label_value($label, $value)
{
    echo '<div class="label-value"><span class="label">' . $label . '</span><span class="value">' . $value . '</span></div>';
}

?>

<div class="card-background">
    <h1><?php echo $student->first_name . ' ' . $student->last_name; ?></h1>
    <a href="form/student.php?sid=<?php echo $sid; ?>">[Edit]</a>

    <h2>Employer</h2>
    <?php
    label_value('Company name', $employer->name);
    label_value('Address', $employer->address);
    label_value('CGT Fields', implode(', ', $cgt_fields));
    ?>

    <h2>Work Session</h2>
    <?php
    label_value('Job title', $session->job_title);
    label_value('Start date', $session->start_date);
    label_value('End date', $session->end_date);
    label_value('Address', $session->address ? $session->address : '(same as employer address)');
    label_value('Total hours', $session->total_hours);
    label_value('Pay rate', '$' . number_format($session->pay_rate, 2));
    ?>

    <h2>Questionnaire</h2>
    <?php label_value('Was the internship off-site?', $session->offsite ? 'Yes' : 'No'); ?>
    <hr/>
    <?php label_value('List 5 activities that you regularly performed during the internship. Give examples of activities.', $form->form_activities); ?>
    <hr/>
    <?php label_value('Did the supervisor give you relevant work to accomplish? Specify!', $form->form_relevant_work); ?>
    <hr/>
    <?php label_value('Difficulties or problem areas encountered during internship.', $form->form_difficulties); ?>
    <hr/>
    <?php label_value("Explain how work experience related to your major.", $form->form_related_to_major); ?>
    <hr/>
    <?php label_value("Is there anything you wanted to learn during internship that you were not able to?", $form->form_wanted_to_learn); ?>
    <hr/>
    <?php label_value("Has this work experience changed your mind about which sector of CGT you might be most interested in pursuing?", $form->form_cgt_changed_mind); ?>
    <hr/>
    <?php label_value("Did the internship provide you with contacts which may lead to future employment?", $form->form_provided_contacts); ?>
</div>


<?php include '.\..\footer.php'; ?>
