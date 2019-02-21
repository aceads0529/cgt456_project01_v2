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
            if (v !== undefined && v === option.value) {
                option.html.prop("checked", true);
                return this;
            } else if (option.html.prop("checked")) {
                result.push(option.value);
            }
        }
        return result;
    }

    clear() {
        for (const option of this.options) {
            option.html.prop("checked", false);
        }
    }

    setOptions(options) {
        this.options = options;

        for (const option of this.options) {
            const element = this.itemTemplate.clone();
            this.itemContainer.append(element);

            const input = element.find('[data-option-input]');
            const label = element.find('[data-option-label]');

            label.attr('for', this.id + '-' + option.name);
            label.text(option.name);

            input.attr('id', this.id + '-' + option.name);
            option.html = input;
        }
    }
}