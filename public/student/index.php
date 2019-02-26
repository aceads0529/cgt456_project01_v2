<?php include '.\..\header.php';
$user = require_login();
$sessions = WorkSessionDao::get_instance()->select_student($user->id);
?>

<div id="page-wrapper">

    <h2>Internship Sessions</h2>

    <table>
        <thead>
        <tr>
            <th><a href="form/student.php">+ Create new</a></th>
        </tr>
        <tr>
            <th>Start date</th>
            <th>End date</th>
            <th>Company name</th>
            <th>Job title</th>
            <th>Total hours</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php if ($sessions):
            $total_hours = 0;
            foreach ($sessions as $session):
            $employer = EmployerDao::get_instance()->select($session->employer_id)[0];
            ?>
            <tr>
                <td><?php echo $session->start_date; ?></td>
                <td><?php echo $session->end_date; ?></td>
                <td><?php echo $employer->name; ?></td>
                <td><?php echo $session->job_title; ?></td>
                <td><?php echo $session->total_hours; ?></td>
                <td><a href="form/student.php?sid=<?php echo $session->id; ?>">[view]</a></td>
                <td><a href="form/student.php?sid=<?php echo $session->id; ?>">[Edit]</a></td>
                <td><a onclick="deleteSession(<?php echo $session->id; ?>)">[Delete]</a></td>
            </tr>
            <?php $total_hours += $session->total_hours; endforeach; endif; ?>
        </tbody>
        <?php echo $total_hours; ?>
    </table>

    <div class="form-button-row">
        <a href="form/student.php">+ Create new</a>
    </div>

</div>

<script>
    function deleteSession(id) {
        $api.call("submit/delete", {workSessionId: id}, response => {
            if (response.success) {
                location.reload();
            }
        });
    }
</script>

<?php include '.\..\footer.php'; ?>
