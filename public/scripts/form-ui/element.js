class Element {
    constructor(id, label, required = true, validator = null) {
        this.id = id;
        this.label = label;
        this.required = required;
        this.validator = validator;
    }

    static loadTemplates(callback) {
        Element.templates = {};

        $.get("/scripts/form-ui/_templates.php", {}, function (response) {
            let templates = response.split("@Template");

            for (let templStr of templates) {
                let split = templStr.indexOf("<");
                let key = templStr.substring(0, split).trim();

                if (key !== "")
                    Element.templates[key] = templStr.substring(split).trim();
            }

            callback()
        });
    }

    getTemplate() {
        let proto = Object.getPrototypeOf(this);
        while (!Element.templates.hasOwnProperty(proto.constructor.name)) {
            proto = Object.getPrototypeOf(proto);
        }
        return Element.templates[proto.constructor.name] || '<div></div>';
    }

    load() {
        let template = this.getTemplate();
        template = this._formatTemplate(template);
        this.html = $(template);
        this._prepareTemplate();
    }

    value(v) {
        return null;
    }

    validate() {
        const valid = this.validator ? this.validator(this.value()) : true;
        return valid && this.complete();
    }

    complete() {
        return this.id === null || !this.required || !!this.value();
    }

    style(styles) {
        this.html.addClass(styles);
        return this;
    }

    getElement(name) {
        const attr = 'data-' + name;

        if (this.html.attr(attr) !== undefined) {
            return this.html;
        } else {
            return this.html.find('[data-' + name + ']');
        }
    }

    hidden(v) {
        if (v !== undefined) {
            this.html.toggleClass('hidden', v);
            return this;
        } else {
            return this.html.hasClass('hidden');
        }
    }

    _prepareTemplate() {
    }

    _formatTemplate(template) {
        return template.replace(/%id%/g, this.id).replace(/%label%/g, this.label);
    }
}

const $form = {
    ready: Element.loadTemplates
};
