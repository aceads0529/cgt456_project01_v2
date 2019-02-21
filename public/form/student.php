<?php include '../header.php'; ?>

    <div id="form-student"></div>

    <script>
        $form.ready(function () {
            const search = new SearchElement("name", "Name", []).itemLabel("name").debounce(1000);

            const employerForm = new GroupElement("form", "Employer")
                .append(new ReadonlyElement("id", null))
                .append(search)
                .append(new TextElement("address", "Address"))
                .append(new OptionElement("cgtField", "CGT Field", "checkbox", [
                    "Animation",
                    "Construction",
                    "Data Visualization",
                    "Game",
                    "UX",
                    "Visual FX",
                    "VPI",
                    "Web Programming"]));

            search.onChange(function (value) {
                $api.call('submit/search', {name: value}, function (response) {
                    search.updateItems(response.data);
                });
            });

            search.onSelect(function (data) {
                employerForm.getField("id").value(data.id);
                employerForm.getField("address").value(data.address);

                // console.log(data);
            });

            $('#form-student').append(employerForm.html);
        });
    </script>

<?php include '../footer.php'; ?>