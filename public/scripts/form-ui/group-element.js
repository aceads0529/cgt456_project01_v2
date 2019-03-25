class GroupElement extends Element {
    constructor(id, label = "", required = true, validator = null) {
        super(id, label, required, validator);
        this.children = [];

        this.load();

        this.anon = 0;
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
        const id = element.id !== null ? element.id : this.anon++;

        this.children[id] = element;
        this.html.append(element.html);

        return this;
    }

    getField(id) {
        if (this.children.hasOwnProperty(id))
            return this.children[id];
        else {
            for (const key of Object.keys(this.children)) {
                const child = this.children[key];

                if (typeof child.getField !== "undefined") {
                    const result = child.getField(id);
                    if (result) {
                        return result;
                    }
                }
            }
            return null;
        }
    }

    validate() {
        if (super.validate()) {
            for (let child in this.children) {
                if (!this.children[child].validate()) {
                    return false;
                }
            }

            return true;
        } else {
            return false;
        }
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
        if (!this.required) {
            return true;
        } else {
            for (let child in this.children) {
                if (!this.children[child].complete()) {
                    return false;
                }
            }
            return true;
        }
    }
}
