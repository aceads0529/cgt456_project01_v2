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