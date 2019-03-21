<?php header('Content-Type: text/plain'); ?>

@Template GroupElement
<div class="form-group">
    <h2 data-label class="label">%label%</h2>
    <div data-error class="error"></div>
</div>

@Template AlternatingGroupElement
<div class="form-group alternating">
    <h2 data-label class="label">%label%</h2>
    <div data-error class="error"></div>
</div>

@Template TextElement
<div class="form-row">
    <div class="label-input">
        <label for="%id%">%label%</label>
        <input data-text type="text" id="%id%"/>
    </div>
</div>

@Template TextareaElement
<div class="form-row">
    <div class="label-input">
        <label for="%id%">%label%</label>
        <textarea data-text id="%id%" rows="6"></textarea>
    </div>
</div>

@Template OptionElement
<div class="form-row">
    <div class="label-input">
        <label>%label%</label>
        <div data-options class="options">
            <div class="option-group" data-option-group>
                <div class="option" data-option>
                    <input data-option-input type="%type%" name="%id%"/>
                    <label data-option-label></label>
                </div>
            </div>
        </div>
    </div>
</div>

@Template LikertElement
<div class="form-row">
    <div class="label-input">
        <label id="likert-label">%label%</label>
        <div data-options class="likerts">
            <div class="likert-group" data-option-group>
                <div class="likert" data-option>
					<label data-option-label></label><br>
					<input data-option-input type="%type%" name="%id%"/>
                </div>
            </div>
        </div>
    </div>
</div>


@Template MessageElement
<div class="form-message">
    <span data-output></span>
</div>

@Template ButtonElement
<button data-button id="%id%" class="form-button">%label%</button>

@Template RowElement
<div data-row class="form-button-row"></div>

@Template ReadonlyElement
<input type="hidden"/>

@Template SearchElement
<div class="form-row">
    <div class="label-input">
        <label for="%id%">%label%</label>
        <div class="searchbox">
            <input data-text type="text" autocomplete="off" id="%id%"/>
            <ul class="search-results" data-search-list>
                <li data-search-item></li>
            </ul>
        </div>
    </div>
</div>

@Template FileElement
<div class="form-row">
    <div class="label-input">
		<input type="hidden" name="MAX_FILE_SIZE" value="200000000" />
        <label for="%id%">%label%</label>
		<input data-file type="file" name="%id%" id="%id%" multiple />
    </div>
</div>
