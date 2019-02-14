class ButtonElement extends Element {
    constructor(id, label, onClick) {
        super(id, label);
        this.onClick = onClick;
        this.load();
    }

    _prepareTemplate() {
        this.getElement('button').click((e) => {
            this.onClick();
        })
    }

    value(v) {
        if (v !== undefined) {
            return this;
        } else {
            return undefined;
        }
    }
}
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

    load() {
        const name = this.constructor.name;
        if (Element.templates.hasOwnProperty(name)) {
            this.html = $(this._formatTemplate(Element.templates[name]));
            this._prepareTemplate();
        } else {
            this.html = $('<div></div>');
        }
    }

    value(v) {
        return null;
    }

    validate() {
        if (this.validator)
            return this.validator(this.value());
        else
            return true;
    }

    complete() {
        return true;
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
class GroupElement extends Element {
    constructor(id, label = "", required = true, validator = null) {
        super(id, label, required, validator);
        this.children = [];

        this.load();
    }

    _prepareTemplate() {
        if (!this.label) {
            this.getElement('label').remove();
        }

        this.errorElem = this.getElement('error');
    }

    error(message) {
        if (message !== undefined) {
            if (this.errorElem) {
                this.errorElem.text(message);
                return this;
            }
        } else {
            return this.errorElem.text();
        }
    }

    append(element) {
        const id = element.id !== null ? element.id : new Date();

        this.children[id] = element;
        this.html.append(element.html);

        return this;
    }

    getField(id) {
        if (this.children.hasOwnProperty(id))
            return this.children[id];
        else
            return null;
    }

    printMessage(elementId, message) {
        const field = this.getField(elementId);

        if (field && field.constructor.name === "MessageElement") {
            field.value(message);
        }

        return this;
    }

    validate() {
        super.validate();

        for (let child in this.children) {
            if (!this.children[child].validate())
                return false;
        }

        return true;
    }

    value(v) {
        let result = {};

        for (let child in this.children) {
            const field = this.children[child];
            const v = field.value();

            if (field.id !== null) {
                if (v !== undefined) {
                    result[child] = v;
                }
            } else {
                result = Object.assign(result, v);
            }
        }

        return result;
    }

    complete() {
        if (this.required) {
            for (let child in this.children) {
                if (!this.children[child].complete())
                    return false;
            }
        }

        return true;
    }
}
class RatingElement extends Element {
    constructor(id, label, count = 5, required = false, validator = null) {
        super(id, label, required, validator);
        this.count = count;

        this.load()
    }

    _prepareTemplate() {
        const radioTempl = this.getElement('radio-group');
        const radioContainer = this.getElement('options');

        this.options = [];

        const isArr = Array.isArray(this.count);
        const len = isArr ? this.count.length : this.count;

        for (let i = 0; i < len; i++) {
            const radioGroup = radioTempl.clone();
            radioContainer.append(radioGroup);

            const radio = radioGroup.find('[data-radio]');
            const label = radioGroup.find('[data-radio-label]');

            const tag = isArr ? this.count[i] : i;

            label.attr('for', this.id + '-' + tag);
            label.text(tag);

            radio.attr('id', this.id + '-' + tag);

            this.options[i] = radio;
        }

        radioTempl.remove();
    }

    value(v) {
        if (v !== undefined && v >= 0 && v < this.count) {
            this.options[v].prop("checked", true);
            return this;
        } else {
            for (let i = 0; i < this.count; i++) {
                if (this.options[i].prop("checked"))
                    return i;
            }

            return -1;
        }
    }
}
class ReadonlyElement extends Element {
    constructor(id, value) {
        super(id, "");
        this.load();
        this.value(value);
    }

    value(v) {
        if (v !== undefined) {
            this.html.val(v);
            return this;
        } else {
            return this.html.val();
        }
    }
}
class RowElement extends GroupElement {
    constructor(id = null) {
        super(id, "");
    }
}
class TextElement extends Element {
    constructor(id, label, type = 'text', required = false, validator = null) {
        super(id, label, required, validator);
        this.type = type;
        this.load();
    }

    value(v) {
        if (v !== undefined) {
            this.textbox.val(v);
            return this;
        } else {
            return this.textbox.val();
        }
    }

    complete() {
        return this.value() !== "";
    }

    _prepareTemplate() {
        this.textbox = this.getElement('text');
        this.textbox.attr('type', this.type);
    }
}

class TextareaElement extends TextElement {
    constructor(id, label, required = false, validator = null) {
        super(id, label, required, validator);
    }
}