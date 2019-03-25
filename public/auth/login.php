<?php include '../site.php';
site_header('Login', CGT_PAGE_FULL);
?>
<div id="login-wrapper">
    <div id="login-background"></div>
    <form id="login-form" class="card-background">
        <div id="page-title"></div>
    </form>
</div>

<script>
    $form.ready(() => {
        const buttonRow = new RowElement();

        const form = new GroupElement("form", "Polytechnic Internship Portal")
            .append(new TextElement("login", "Username"))
            .append(new TextElement("password", "Password", "password"))
            .append(buttonRow
                .append(new ButtonElement("submit", "Login")));

        buttonRow.html.prepend(`<a href="auth/register.php">Register</a>`);

        const formHost = $("#login-form");
        formHost.append(form.html);

        formHost.submit((event) => {
            event.preventDefault();

            if (form.validate()) {
                $api.call('user/login', form.value(), function (response) {
                    if (response.success && response.data.redirect) {
                        location.replace(response.data.redirect);
                    }
                });
            } else {
                form.error("Missing required fields");
            }
        });
    });
</script>
