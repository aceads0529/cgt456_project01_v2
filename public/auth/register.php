<?php include '../site.php';
site_header('Login', CGT_PAGE_FULL);
?>
<div id="login-wrapper">
    <div id="login-background"></div>
    <form id="login-form" style="max-width: 800px" class="card-background">
        <div id="page-title"></div>
    </form>
</div>

<script>
    $form.ready(function () {
        const buttonRow = new RowElement();

        const form = new GroupElement("form", "Polytechnic Internship Portal &mdash; Register")
            .append(new TextElement("login", "Login"))
            .append(new TextElement("password", "Password", "password"))
            .append(new TextElement("firstName", "First name"))
            .append(new TextElement("lastName", "Last name"))
            .append(new TextElement("email", "Email", "email"))
            .append(new TextElement("phone", "Phone", "phone"))
            .append(new ReadonlyElement("userGroupId", "student"))
            .append(buttonRow
                .append(new ButtonElement("submit", "Register")));

        buttonRow.html.prepend(`<a href="auth/login.php">Login</a>`);

        const formContainer = $("#login-form");
        formContainer.append(form.html);
        formContainer.submit((event) => {
            event.preventDefault();

            if (form.validate()) {
                $api.call('user/register', form.value(), function (response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        form.error(response.message);
                    }
                });
            } else {
                form.error('Missing required fields');
            }
        });
    });
</script>
