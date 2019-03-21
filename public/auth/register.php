<?php include '../site.php';
site_header('Register', CGT_PAGE_FORM); ?>

    <form id="form-login"></form>

    <script>
        $form.ready(function () {
            const form = new GroupElement("form", "New Account")
                .append(new TextElement("login", "Login"))
                .append(new TextElement("password", "Password", "password"))
                .append(new TextElement("firstName", "First name"))
                .append(new TextElement("lastName", "Last name"))
                .append(new TextElement("email", "Email", "email"))
                .append(new TextElement("phone", "Phone", "phone"))
                .append(new ReadonlyElement("userGroupId", "student"))
                .append(new RowElement()
                    .append(new ButtonElement("submit", "Register", onSubmit)));

            $('#form-login').append(form.html);

            function onSubmit() {
                console.log(form.value());

                if (form.complete()) {
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
            }
        });
    </script>

<?php include '../footer.php'; ?>
