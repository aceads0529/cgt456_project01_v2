class ButtonElement extends Element {
    constructor(id, label, onClick) {
        super(id, label);
        this.onClick = onClick;
        this.load();
    }

    _prepareTemplate() {
        this.getElement('button').click((e) => {
            if (this.onClick) {
                this.onClick(e);
            }
        })
    }

    value(v) {
        if (v !== undefined) {
            return this;
        } else {
            return undefined;
        }
    }

    complete() {
        return true;
    }
}
