<?php include '../header.php'; ?>

    <form id="form-login">
        <div class="ui-right">
            <input type="submit" class="accent" value="Login"/>
        </div>
    </form>

    <div id="form-login"></div>
    <script>
        $form.ready(function () {
            const loginForm = new GroupElement("login", "Login")
                .append(new TextElement("login", "Login"))
                .append(new TextElement("password", "Password"));

            $('#form-login').prepend(loginForm.html);
            $('#form-login').submit(function (e) {
                e.preventDefault();

                $api.call('user/login', loginForm.value(), function (response) {
                    console.log(response);
                });
            });
        });
    </script>

<?php include '../footer.php'; ?>