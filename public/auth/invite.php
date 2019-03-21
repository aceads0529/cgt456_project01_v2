<?php include '../site.php';
site_header('Supervisor Survey Invitation', CGT_PAGE_FORM);

$guest_id = isset($_GET['id']) ? (int)$_GET['id'] : null;
$hash = isset($_GET['h']) ? $_GET['h'] : null;

$redirect_url = false;

$message = '';

if ($guest_id !== null && $hash !== null) {
    if ($redirect_url = AuthService::guest_redirect($guest_id, $hash)) {
        header('Location: ' . $redirect_url);
        exit;
    } else {
        $message = 'Email given is incorrect. Please try again.';
    }
}
?>

<form id="form-guest">
</form>

<div id="form-login"></div>
<script>
    $form.ready(function () {
        const guestForm = new GroupElement("guest", "Guest Login")
            .append(new TextElement("email", "Email"))
            .append(new RowElement()
                .append(new ButtonElement("next", "Continue")));

        guestForm.error('<?php echo $message; ?>');

        const host = $('#form-guest');
        host.append(guestForm.html);

        host.submit(function (e) {
            e.preventDefault();

            const url = new URL(window.location);
            const guestId = url.searchParams.get("id") !== null ? parseInt(url.searchParams.get("id")) : null;
            const hash = md5(guestForm.value().email);
            location.replace(url.pathname + "?id=" + guestId + "&h=" + hash);
        });
    });
</script>

<?php include '../footer.php'; ?>

