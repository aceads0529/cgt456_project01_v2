<?php include '../header.php'; ?>

    <div id="form-student"></div>

    <script>
        $form.ready(function () {
            const form = new GroupElement("form", "CompanyInfo")
                .append(new TextElement("companyName", "Name of Company"))
                .append(new TextElement("conpanyAddress", "Address of Home/Main Office"))
                .append(new TextElement("cgtIndustry", "First name")) //NOT FINISHED: CGT Majors check boxes
                .append(new TextElement("companyOtherAddress", "Location of job site where you worked, if different than the main office"))
                .append(new RowElement()
                    .append(new ButtonElement("next", ">", onNext)));

            const form = new GroupElement("form", "WorkPeriod")
                .append(new TextElement("startDate", "Start Date"))
                .append(new TextElement("endDate", "End Date"))
                .append(new TextElement("hourWork", "Total Hours Worked"))
                .append(new RowElement()
                    .append(new ButtonElement("next", ">", onNext)));

            const form = new GroupElement("form", "Questionnaire")
                .append(new TextElement("onSite", "Did you work in an office or on site?")) //NOT FINISHED: Dropdown
                .append(new TextElement("activity", "List 5 activities that you regularly performed during the internship. Give examples of activities.")) //NOT FINISHED: Check with aaron
                .append(new TextElement("relavantWork", "Did the supervisor give you relevant work to accomplish? Specify!"))
                .append(new TextElement("difficulties", "Difficulties or problem areas encountered during internship."))
                .append(new TextElement("relatedMajor", "Explain how work experience related to your major."))
                .append(new TextElement("wantedLearn", "Is there anything you wanted to learn during internship that you were not able to?"))
                .append(new TextElement("changeMind", "Has this work experience changed your mind about which sector of CGT you might be most interested in pursuing?"))
                .append(new TextElement("provideContacts", "Did the internship provide you with contacts which may lead to future employment?"))
                .append(new TextElement("rateExperience", "Considering your overall experience, how would you rate this internship?")) //NOT FINISHED: Radio
                .append(new RowElement()
                    .append(new ButtonElement("next", ">", onNext)));

            const form = new GroupElement("form", "Salary")
                .append(new TextElement("paid", "Were you paid?")) //NOT FINISHED: Radio button
                .append(new TextElement("hourlyRate", "If so, how much per hour?"))
                .append(new TextElement("housingStipend", "Did you receive a housing stipend?")) //NOT FINISHED: Radio button
                .append(new TextElement("assistance", "Did you receive any assistance from the company for your internship? Please select all that apply")) //NOT FINISHED: Check box
                .append(new RowElement()
                    .append(new ButtonElement("submit", "Submit", onSubmit)));

            $('#form-student').append(form.html);

            function onNext() {
                
            }
            
            function onSubmit() {
                console.log(form.value());

                if (form.complete()) {
                    $api.call('submit/employer', form.value(), function (response) {
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