<?php include '.\..\header.php';

$user = new User();

try {
    $user = AuthService::get_active_user_or_deny();
} catch (ResponseException $e) {
    $e->getResponse()->echo(true);
}

$sessions = WorkSessionDao::get_instance()->select_student($user->id);
?>

<ul>
    <?php if ($sessions): foreach ($sessions as $session): ?>
        <li><a href="/form/student.php?sid=<?php echo $session->id; ?>"><?php echo $session->job_title; ?></a></li>
    <?php endforeach; endif; ?>
    <li><a href="form/student.php">+ New</a></li>
</ul>

<?php include '.\..\footer.php'; ?>
