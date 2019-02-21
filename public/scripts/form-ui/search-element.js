class SearchElement extends Element {
    constructor(id, label, items = [], required = true) {
        super(id, label, required);
        this.items = items;

        this.listFocus = false;
        this.load();

        this.onItemSelected = null;
        this.onTextChanged = null;

        this.delay = 0;
        this._itemLabel = "label";
    }

    _prepareTemplate() {
        this.textbox = this.getElement('text');
        this.searchList = this.getElement('search-list');
        this.searchItem = this.getElement('search-item');

        this.searchItem.remove();
        this._renderItems();

        this.searchList.mouseenter(() => {
            this.listFocus = true;
        });

        this.searchList.mouseleave(() => {
            this.listFocus = false;
        });

        this.textbox.focusin(() => {
            this.searchList.addClass('show');
        });

        this.textbox.focusout(() => {
            if (!this.listFocus) {
                this.searchList.removeClass('show');
            }
        });

        this.textbox.keydown((e) => {
            SearchElement.debounce(() => {
                if (this.onTextChanged) {
                    this.onTextChanged(this.value());
                }
            }, this.delay)();
        });
    }

    value(v) {
        if (v !== undefined) {
            this.textbox.val(v);
            return this;
        } else {
            return this.textbox.val();
        }
    }

    onSelect(callback) {
        this.onItemSelected = callback;
        return this;
    }

    onChange(callback) {
        this.onTextChanged = callback;
        return this;
    }

    updateItems(items) {
        this.items = items;
        this._renderItems();
    }

    itemLabel(v) {
        if (v !== undefined) {
            this._itemLabel = v;
            return this;
        } else {
            return this._itemLabel;
        }
    }

    debounce(v) {
        if (v !== undefined) {
            this.delay = v;
            return this;
        } else {
            return this.delay;
        }
    }

    static debounce(func, wait, immediate) {
        let timeout;
        return function () {
            const context = this, args = arguments;

            const later = function () {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };

            const callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);

            if (callNow) {
                func.apply(context, args);
            }
        };
    };

    _renderItems() {
        this.searchList.children().remove();

        for (const item of this.items) {
            const listItem = this.searchItem.clone();
            listItem.text(item[this.itemLabel()]);
            this.searchList.append(listItem);
            listItem.data('value', item);
            listItem.click((e) => this._onItemClick(e));
        }
    }

    _onItemClick(e) {
        const data = $(e.target).data('value');

        this.textbox.val(data[this.itemLabel()]);
        this.searchList.removeClass('show');

        if (this.onItemSelected) {
            this.onItemSelected(data);
        }
    }
}