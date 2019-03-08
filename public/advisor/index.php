<?php include '.\..\header.php';
$user = require_login();
$sessions = WorkSessionDao::get_instance()->select();
?>

<div class="card-background">
    <h1>Internships</h1>
    <h2>Work Sessions</h2>

    <table>
        <thead>
        <tr>
            <th>Student ID</th>
            <th>Student</th>
            <th>Start date</th>
            <th>End date</th>
            <th>Company name</th>
            <th>Job title</th>
            <th>Hours</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php if ($sessions):
            $total_hours = 0;
            foreach ($sessions as $session):
                $employer = EmployerDao::get_instance()->select($session->employer_id)[0];
                $student = UserDao::get_instance()->select($session->student_id)[0];
                ?>
                <tr>
                    <td><?php echo $session->student_id; ?></td>
                    <td><?php echo $student->first_name . ' ' . $student->last_name; ?></td>
                    <td><?php echo $session->start_date; ?></td>
                    <td><?php echo $session->end_date; ?></td>
                    <td><?php echo $employer->name; ?></td>
                    <td><?php echo $session->job_title; ?></td>
                    <td><?php echo $session->total_hours; ?></td>
                    <td>
                        <a href="student/session.php?sid=<?php echo $session->id; ?>">[View]</a>

                        <?php if ($session->approved === 1): ?>
                            <span style="color: green">Approved</span>
                        <?php else: ?>
                            <a style="text-decoration: underline; cursor: pointer;"
                               onclick="approveSession(<?php echo $session->id; ?>)">[Approve]</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php $total_hours += $session->total_hours; endforeach; endif; ?>
        </tbody>
    </table>
</div>

<script>
    function approveSession(id) {
        $api.call("supervisor/form-approve", {sessionId: id}, response => {
            if (response.success) {
                location.reload();
            }
        });
    }
</script>

<?php include '.\..\footer.php'; ?>
