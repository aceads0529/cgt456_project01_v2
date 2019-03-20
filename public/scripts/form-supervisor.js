const forms = [];

function showForm(form) {
    forms.forEach((item, index) => item.html.toggleClass("hide", index !== form));
	
	$("html, body").animate({ scrollTop: 0 }, "fast"); //scrolls to top of page after click
	
	for(var i = 0; i < forms.length; i++) {
		if(i <= form) { $("#progressbar #"+i).addClass("active"); }
		else { $("#progressbar #"+i).removeClass("active"); }
	} //progress bar
}

function onSubmit() {
    const prompts = {...forms[0].value(), ...forms[1].value(), ...forms[2].value()};

    const url = new URL(window.location);
    const sessionId = url.searchParams.get("sid") !== null ? parseInt(url.searchParams.get("sid")) : null;

    if (sessionId) {
        $api.call('supervisor/form', {sessionId: sessionId, prompts: prompts}, response => {
            if (response.success) {
                location.replace('auth/login.php');
            }
        });
    }
}

function createSupervisorOne() {
    const form = new AlternatingGroupElement("one", "Intern Evaluation (1/3)")
        .append(new LikertElement("dependable", "Performs in a dependable manner"))
        .append(new LikertElement("cooperative", "Cooperates with co-workers and supervisors"))
        .append(new LikertElement("interested", "Shows interest in work"))
        .append(new LikertElement("fastLearner", "Learns quickly"))
        .append(new LikertElement("initiative", "Shows initiative"))
        .append(new LikertElement("workQuality", "Produces high quality work"))
        .append(new LikertElement("responsibility", "Accepts responsibility"))
        .append(new RowElement()
            .append(new ButtonElement("next", "Next", () => showForm(1))));

    return form;
}

function createSupervisorTwo() {
    const form = new AlternatingGroupElement("two", "Intern Evaluation (2/3)")
        .append(new LikertElement("criticism", "Accepts criticism"))
        .append(new LikertElement("organization", "Demonstrates organizational skills"))
        .append(new LikertElement("techKnowledge", "Demonstrates technical knowledge and expertise"))
        .append(new LikertElement("judgement", "Shows good judgment"))
        .append(new LikertElement("creativity", "Demonstrates creativity/originality"))
        .append(new LikertElement("problemAnalysis", "Analyzes problems effectively"))
        .append(new LikertElement("selfReliance", "Is self-reliant"))
        .append(new RowElement()
            .append(new ButtonElement("prev", "Previous", () => showForm(0)))
            .append(new ButtonElement("next", "Next", () => showForm(2))));

    return form;
}

function createSupervisorThree() {
    const form = new AlternatingGroupElement("three", "Intern Evaluation (3/3)")
        .append(new LikertElement("communication", "Communicates well"))
        .append(new LikertElement("writing", "Writes effectively"))
        .append(new LikertElement("profAttitude", "Has a professional attitude"))
        .append(new LikertElement("profAppearance", "Gives a professional appearance"))
        .append(new LikertElement("punctuality", "Is punctual"))
        .append(new LikertElement("timeEffective", "Uses time effectively"))
        .append(new RowElement()
            .append(new ButtonElement("prev", "Previous", () => showForm(1)))
            .append(new ButtonElement("submit", "Submit", () => onSubmit())));

    return form;
}

$form.ready(function () {
    const host = $('#form-supervisor');

    forms.push(
        createSupervisorOne(),
        createSupervisorTwo(),
        createSupervisorThree());

    for (const f of forms) {
        host.append(f.html);
    }
    showForm(0);

    host.submit(e => {
        e.preventDefault();
    });
});
