<?php include '../site.php';
site_header('Logout', CGT_PAGE_FORM_SM); ?>

<script>
    $api.call("user/logout", {}, () => {
        location.replace('/auth/login.php');
    });
</script>

<?php include '../footer.php'; ?>
