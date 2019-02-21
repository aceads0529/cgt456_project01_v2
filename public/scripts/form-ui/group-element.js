class GroupElement extends Element {
    constructor(id, label = "", required = true, validator = null) {
        super(id, label, required, validator);
        this.children = [];

        this.load();
    }

    _prepareTemplate() {
        if (!this.label) {
            this.getElement('itemLabel').remove();
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