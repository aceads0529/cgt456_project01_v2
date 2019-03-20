class OptionElement extends Element {
    constructor(id, label, options, type = "radio", required = false, validator = null) {
        super(id, label, required, validator);
        this.type = type;
        this.options = options;
        this.load()
    }

    _prepareTemplate() {
        this.itemTemplate = this.getElement('option');
        this.itemContainer = this.getElement('option-group');
        this.setOptions(this.options);
        this.itemTemplate.remove();
    }

    _formatTemplate(template) {
        return super._formatTemplate(template).replace('%type%', this.type);
    }

    value(v) {
        const result = [];
        for (const option of this.options) {
            if (v !== undefined && (v === option.value || Array.isArray(v) && v.includes(option.value))) {
                option.html.prop("checked", true);
            } else if (option.html.prop("checked")) {
                result.push(option.value);
            }
        }

        if (v !== undefined) {
            return this;
        } else {
            return this.type === "radio" ? result[0] || null : result;
        }
    }

    clear() {
        for (const option of this.options) {
            option.html.prop("checked", false);
        }
    }

    setOptions(options) {
        this.options = options;

        for (let i = 0; i < this.options.length; i++) {
            const option = this.options[i];

            const element = this.itemTemplate.clone();
            this.itemContainer.append(element);

            const input = element.find('[data-option-input]');
            const label = element.find('[data-option-label]');

            label.attr('for', this.id + '-' + option.name);
            label.text(option.name);

            input.attr('id', this.id + '-' + option.name);
            this.options[i]['html'] = input;
        }
    }
}

class RatingElement extends OptionElement {
    constructor(id, label, required = true) {
        super(id, label, [
            {
                name: "Very good",
                value: 4
            }, {
                name: "Good",
                value: 3
            }, {
                name: "Okay",
                value: 2
            }, {
                name: "Bad",
                value: 1
            }, {
                name: "Very bad",
                value: 0
            }
        ], "radio", required);
    }
}

class LikertElement extends OptionElement {
    constructor(id, label, required = true) {
        super(id, label, [
            {
                name: "Very good",
                value: 4
            }, {
                name: "Good",
                value: 3
            }, {
                name: "Okay",
                value: 2
            }, {
                name: "Bad",
                value: 1
            }, {
                name: "Very bad",
                value: 0
            }
        ], "radio", required);
    }
}

class YesNoElement extends OptionElement {
    constructor(id, label, required = true) {
        super(id, label, [
            {
                name: "Yes",
                value: 1
            }, {
                name: "No",
                value: 0
            }
        ], "radio", required);
    }
}
