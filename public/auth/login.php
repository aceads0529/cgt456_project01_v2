<?php include '../site.php';
site_header('Login', CGT_PAGE_FORM_SM); ?>

<form id="form-login"></form>

<div id="form-login"></div>
<script>
    $form.ready(function () {
        const loginForm = new GroupElement("login")
            .append(new TextElement("login", "Login"))
            .append(new TextElement("password", "Password", "password"))
            .append(new RowElement()
                .append(new ButtonElement("btn-login", "Login")));

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
