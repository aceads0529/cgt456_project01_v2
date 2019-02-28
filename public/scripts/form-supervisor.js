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
    const data = {...forms[0].value(), ...forms[1].value(), ...forms[2].value()};
    console.log(data);
}

function createSupervisorOne() {
    const form = new GroupElement("one", "Intern Evaluation (1/3)")
        .append(new RatingElement("dependable", "Performs in a dependable manner"))
        .append(new RatingElement("cooperative", "Cooperates with co-workers and supervisors"))
        .append(new RatingElement("interested", "Shows interest in work"))
        .append(new RatingElement("fastLearner", "Learns quickly"))
        .append(new RatingElement("initiative", "Shows initiative"))
        .append(new RatingElement("workQuality", "Produces high quality work"))
        .append(new RatingElement("responsibility", "Accepts responsibility"))
        .append(new RowElement()
            .append(new ButtonElement("next", "Next", () => showForm(1))));

    return form;
}

function createSupervisorTwo() {
    const form = new GroupElement("two", "Intern Evaluation (2/3)")
        .append(new RatingElement("criticism", "Accepts criticism"))
        .append(new RatingElement("organization", "Demonstrates organizational skills"))
        .append(new RatingElement("techKnowledge", "Demonstrates technical knowledge and expertise"))
        .append(new RatingElement("judgement", "Shows good judgment"))
        .append(new RatingElement("creativity", "Demonstrates creativity/originality"))
        .append(new RatingElement("problemAnalysis", "Analyzes problems effectively"))
        .append(new RatingElement("selfReliance", "Is self-reliant"))
        .append(new RowElement()
            .append(new ButtonElement("prev", "Previous", () => showForm(0)))
            .append(new ButtonElement("next", "Next", () => showForm(2))));

    return form;
}

function createSupervisorThree() {
    const form = new GroupElement("three", "Intern Evaluation (3/3)")
        .append(new RatingElement("communication", "Communicates well"))
        .append(new RatingElement("writing", "Writes effectively"))
        .append(new RatingElement("profAttitude", "Has a professional attitude"))
        .append(new RatingElement("profAppearance", "Gives a professional appearance"))
        .append(new RatingElement("punctuality", "Is punctual"))
        .append(new RatingElement("timeEffective", "Uses time effectively"))
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
        e.preventDefault()
    });
});
