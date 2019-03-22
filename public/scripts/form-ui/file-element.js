class FileElement extends Element {
    constructor(id, label,  type="file") {
        super(id, label);
        this.type = type;
        this.load();
    }
	

	
	//_prepareTemplate() {
    //    this.itemTemplate = this.getElement('file');
        //this.setOptions(this.options);
    //    this.itemTemplate.remove();
    //}

    complete() {
        return this.value();
    }
}