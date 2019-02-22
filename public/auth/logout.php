<?php include '../header.php'; ?>

<script>
    $api.call("user/logout", {}, () => {
        location.replace('/auth/login.php');
    });
</script>

<?php include '../footer.php'; ?>
