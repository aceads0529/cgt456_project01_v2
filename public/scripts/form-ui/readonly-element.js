class ReadonlyElement extends Element {
    constructor(id, value, required = false) {
        super(id, "", required);
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