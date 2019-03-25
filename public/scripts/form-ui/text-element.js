class TextElement extends Element {
    constructor(id, label, type = 'text', required = true, validator = null) {
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
        return !this.required || this.value() !== "";
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
