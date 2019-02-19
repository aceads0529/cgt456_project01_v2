<?php include '../header.php'; ?>

    <div id="form-login"></div>
    <script>
        $form.ready(function () {
            const form = new GroupElement("form", "Account")
                .append(new TextElement("login", "Login"))
                .append(new TextElement("password", "Password", "password"))
                .append(new RowElement()
                    .append(new ButtonElement("submit", "Login", onSubmit)));

            $('#form-login').append(form.html);

            function onSubmit() {
                if (form.complete()) {
                    $api.call('user/login', form.value(), function (response) {
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