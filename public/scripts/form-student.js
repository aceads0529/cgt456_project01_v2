const forms = [];

function showForm(form) {
    forms.forEach((item, index) => item.html.toggleClass("hide", index !== form));
	$("html, body").animate({ scrollTop: 0 }, "fast"); //scrolls to top of page after click
}

function onSubmit() {
    const data = {
        employer: forms[0].value(),
        session: forms[1].value(),
        prompts: forms[2].value()
    };

    $api.call("student/form", data, response => {
        window.location.replace("student/index.php");
    });
}

function createEmployerForm() {
    const employerId = new ReadonlyElement("id", null);
    const employerName = new SearchElement("name", "Company name", [])
        .debounce(1000)
        .itemLabel("name");
    const employerAddress = new TextElement("address", "Address");
    const employerFields = new OptionElement("cgtFields", "Which CGT fields does the company employ?", [], "checkbox")
        .style("wrap");

    const form = new GroupElement("employer", "Employer")
        .append(employerId)
        .append(employerName)
        .append(employerAddress)
        .append(new TextElement("email", "Your supervisor's email address", "email"))
        .append(employerFields)
        .append(new RowElement()
            .append(new ButtonElement("next", "Next", () => showForm(1))));

    $api.call("option/cgt-fields", {}, (response) => {
        employerFields.setOptions(response.data.map(el => {
            return {
                name: el["label"],
                value: el["id"]
            };
        }))
    });

    employerName.onChange((value) => {
        $api.call("search/employer", {search: value}, (response) => {
            employerName.updateItems(response.data);
        });
    }).onSelect((item) => {
        employerId.value(item["id"]);
        employerAddress.value(item["address"]);

        employerFields.clear();

        for (const f of item["cgt_field_ids"]) {
            employerFields.value(f);
        }
    });

    return form;
}

function createSessionForm() {
    const assistance = new OptionElement("assistance", "Did you receive any assistance from the company for your internship?", [], "checkbox");

    $api.call("option/fi", {}, (response) => {
        assistance.setOptions(response.data.map(el => {
            return {
                name: el.label,
                value: el.id
            }
        }))
    });

    return new GroupElement("session", "Work Session")
        .append(new ReadonlyElement("id", null))
        .append(new TextElement("jobTitle", "Job title"))
        .append(new TextElement("address", "Address (if different from company address)"))
        .append(new TextElement("startDate", "Start date", "date"))
        .append(new TextElement("endDate", "End date", "date"))
        .append(new GroupElement("compensation", "Compensation")
            .append(new TextElement("totalHours", "Total hours worked", "number"))
            .append(new TextElement("payRate", "If paid, what was your hourly rate?", "number"))
            .append(assistance))
        .append(new RowElement()
            .append(new ButtonElement("prev", "Previous", () => showForm(0)))
            .append(new ButtonElement("next", "Next", () => showForm(2))));
}

function createPromptsForm() {
    return new GroupElement("form", "Questionnaire")
        .append(new YesNoElement("offsite", "Was the internship off-site?"))
        .append(new TextareaElement("activities", "List 5 activities that you regularly performed during the internship. Give examples of activities."))
        .append(new TextareaElement("relevantWork", "Did the supervisor give you relevant work to accomplish? Specify!"))
        .append(new TextareaElement("difficulties", "Difficulties or problem areas encountered during internship."))
        .append(new TextareaElement("relatedToMajor", "Explain how work experience related to your major."))
        .append(new TextareaElement("wantedToLearn", "Is there anything you wanted to learn during internship that you were not able to?"))
        .append(new TextareaElement("cgtChangedMind", "Has this work experience changed your mind about which sector of CGT you might be most interested in pursuing?"))
        .append(new TextareaElement("providedContacts", "Did the internship provide you with contacts which may lead to future employment?"))
        .append(new RatingElement("rating", "Considering your overall experience, how would you rate this internship?").value(2))
        .append(new RowElement()
            .append(new ButtonElement("prev", "Previous", () => showForm(1)))
            .append(new ButtonElement("submit", "Submit", () => onSubmit())));
}

function populateForm(data) {
    forms[0].getField("id").value(data.employer.id);
    forms[0].getField("name").value(data.employer.name);
    forms[0].getField("address").value(data.employer.address);
    forms[0].getField("cgtFields").value(data.employer.cgt_field_ids);

    forms[1].getField("id").value(data.session.id);
    forms[1].getField("jobTitle").value(data.session.job_title);
    forms[1].getField("address").value(data.session.address);
    forms[1].getField("startDate").value(data.session.start_date);
    forms[1].getField("endDate").value(data.session.end_date);
    forms[1].getField("compensation").getField("totalHours").value(data.session.total_hours);
    forms[1].getField("compensation").getField("payRate").value(data.session.pay_rate);

    forms[2].getField("offsite").value(data.session.offsite);
    forms[2].getField("activities").value(data.prompts.form_activities);
    forms[2].getField("relevantWork").value(data.prompts.form_relevant_work);
    forms[2].getField("difficulties").value(data.prompts.form_difficulties);
    forms[2].getField("relatedToMajor").value(data.prompts.form_related_to_major);
    forms[2].getField("wantedToLearn").value(data.prompts.form_wanted_to_learn);
    forms[2].getField("cgtChangedMind").value(data.prompts.form_cgt_changed_mind);
    forms[2].getField("providedContacts").value(data.prompts.form_provided_contacts);
    forms[2].getField("rating").value(data.prompts.rating);
}

$form.ready(function () {
    const host = $('#form-student');

    forms.push(
        createEmployerForm(),
        createSessionForm(),
        createPromptsForm());


    const url = new URL(window.location);
    const sessionId = url.searchParams.get("sid") !== null ? parseInt(url.searchParams.get("sid")) : null;
    const formId = url.searchParams.get("fid") !== null ? parseInt(url.searchParams.get("fid")) : null;

    if (sessionId !== null) {
        $api.call("student/form-get", {workSessionId: sessionId}, response => {
            if (response.success) {
                populateForm(response.data);
            }

            for (const f of forms) {
                host.append(f.html);
            }
            showForm(formId !== null ? formId : 0);
        });
    } else {
        for (const f of forms) {
            host.append(f.html);
        }
        showForm(formId !== null ? formId : 0);
    }


    host.submit(e => {
        e.preventDefault()
    });
});
