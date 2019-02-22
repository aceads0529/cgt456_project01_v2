<?php include '../header.php';

MailService::email('aceads0529@gmail.com', 'aceads0529@gmail.com', 'Hello, world!', 'The quick brown fox jumps over the lazy dog.');

?>

<form id="form-login"></form>

<div id="form-login"></div>
<script>
    $form.ready(function () {
        const loginForm = new GroupElement("login", "Login")
            .append(new TextElement("login", "Login"))
            .append(new TextElement("password", "Password", "password"))
            .append(new RowElement()
                .append(new ButtonElement("login", "Login")));

        const host = $('#form-login');

        host.append(loginForm.html);
        host.submit(function (e) {
            e.preventDefault();

            $api.call('user/login', loginForm.value(), function (response) {
                if (response.success && response.data.redirect) {
                    location.replace(response.data.redirect);
                }
            });
        });
    });
</script>

<?php include '../footer.php'; ?>
