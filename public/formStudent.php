<?php include './header.php'; ?>

    <form id="form-student"></form>

    <script>
        $form.ready(function () {
            const formContainer = $('#form-student');

            const cgtFields = new OptionElement("cgtFields", "Which CGT field does the company employ?", [], "checkbox").style("wrap");

            $api.call("option/cgt-fields", {}, function (response) {
                cgtFields.setOptions(response.data.map(el => {
                    return {name: el.label, value: el.id}
                }));
            });

            const companySearch = new SearchElement("employerName", "Company Name", [])
                .itemLabel("name")
                .debounce(1000);

            const formEmployer = new GroupElement("formEmployer", "Employer")
                .append(new ReadonlyElement("employerId", null))
                .append(companySearch)
                .append(new TextElement("employerAddress", "Address"))
                .append(new TextElement("supervisorEmail", "Supervisor email", "email"))
                .append(cgtFields)
                .append(new TextareaElement("companyOtherAddress", "Location of job site where you worked (if different than the main office)", false))
                .append(new RowElement()
                    .append(new ButtonElement("next", "Next", () => onNext(1))));

            companySearch.onChange(function (value) {
                $api.call("submit/search", {name: value}, function (response) {
                    companySearch.updateItems(response.data);
                });
            });

            companySearch.onSelect(function (item) {
                formEmployer.getField("employerAddress").value(item.address);
                formEmployer.getField("employerId").value(item.id);
                cgtFields.clear();
                for (const f of item['cgt_field_ids']) {
                    cgtFields.value(f);
                }
            });

            const formSession = new GroupElement("form", "Work Period")
                .append(new TextElement("startDate", "Start Date", "date"))
                .append(new TextElement("endDate", "End Date", "date"))
                .append(new TextElement("hourWork", "Total Hours", "number"))
                .append(new RowElement()
                    .append(new ButtonElement("next", "Next", () => onNext(2))));

            const formPrompts = new GroupElement("form", "Questionnaire")
                .append(new TextareaElement("onSite", "Did you work in an office or on site?")) //NOT FINISHED: Dropdown
                .append(new TextareaElement("activity", "List 5 activities that you regularly performed during the internship. Give examples of activities.")) //NOT FINISHED: Check with aaron
                .append(new TextareaElement("relavantWork", "Did the supervisor give you relevant work to accomplish? Specify!"))
                .append(new TextareaElement("difficulties", "Difficulties or problem areas encountered during internship."))
                .append(new TextareaElement("relatedMajor", "Explain how work experience related to your major."))
                .append(new TextareaElement("wantedLearn", "Is there anything you wanted to learn during internship that you were not able to?"))
                .append(new TextareaElement("changeMind", "Has this work experience changed your mind about which sector of CGT you might be most interested in pursuing?"))
                .append(new TextareaElement("provideContacts", "Did the internship provide you with contacts which may lead to future employment?"))
                .append(new OptionElement("rateExperience", "Considering your overall experience, how would you rate this internship?", [
                    {
                        name: "Very good",
                        value: 5
                    },
                    {
                        name: "Good",
                        value: 4
                    },
                    {
                        name: "Okay",
                        value: 3
                    },
                    {
                        name: "Bad",
                        value: 2
                    },
                    {
                        name: "Very bad",
                        value: 1
                    }]).value(3))
                .append(new RowElement()
                    .append(new ButtonElement("next", "Next", () => onNext(3))));

            const formPay = new GroupElement("form", "Salary")
                .append(new OptionElement("paid", "Were you paid?", [
                    {
                        name: "Yes",
                        value: 1
                    },
                    {
                        name: "No",
                        value: 0
                    }]))
                .append(new TextElement("hourlyRate", "If so, how much per hour?", "number"))
                .append(new OptionElement("stipend", "Did you receive a housing stipend?", [
                    {
                        name: "Yes",
                        value: 1
                    },
                    {
                        name: "No",
                        value: 0
                    }])).append(new TextElement("assistance", "Did you receive any assistance from the company for your internship? Please select all that apply")) //NOT FINISHED: Check box
                .append(new RowElement()
                    .append(new ButtonElement("submit", "Submit", () => onNext(4))));

            formContainer.append(formEmployer.html);
            formContainer.submit((e) => e.preventDefault());

            function onNext(state) {
                switch (state) {
                    case 1:
                        formContainer.children().remove();
                        formContainer.append(formSession.html);

                        break;
                    case 2:
                        formContainer.children().remove();
                        formContainer.append(formPrompts.html);
                        break;
                    case 3:
                        formContainer.children().remove();
                        formContainer.append(formPay.html);
                        break;
                }
            }

            function onSubmit() {
            }
        });
    </script>

<?php include './footer.php'; ?>