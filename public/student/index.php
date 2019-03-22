<?php include '.\..\header.php';
$user = require_login();
$sessions = WorkSessionDao::get_instance()->select_student($user->id);
?>

<div class="card-background">
    <h2>Internship Sessions</h2>

    <table>
        <thead>
        <tr>
            <th>Start date</th>
            <th>End date</th>
            <th>Company name</th>
            <th>Job title</th>
            <th>Hours</th>
            <th><a  href="form/student.php">+ Create new</a></th>
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
                    <td>
                        <a href="student/session.php?sid=<?php echo $session->id; ?>">[View]</a>
                        <a href="form/student.php?sid=<?php echo $session->id; ?>">[Edit]</a>
                        <a style="text-decoration: underline; cursor: pointer;"
                           onclick="deleteSession(<?php echo $session->id; ?>)">[Delete]</a>
                    </td>
                </tr>
                <?php $total_hours += $session->total_hours; endforeach; ?>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>
                    <div class="label-value">
                        <div class="label">Total</div>
                        <div class="value"><?php echo $total_hours; ?></div>
                    </div>
                </td>
                <td></td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
	
	<div class="form-button-row">
        <a href="form/student.php">+ Create new</a>
    </div>

</div>

<script>
    function deleteSession(id) {
        $api.call("student/form-delete", {workSessionId: id}, response => {
            if (response.success) {
                location.reload();
            }
        });
    }
</script>

<?php include '.\..\footer.php'; ?>
