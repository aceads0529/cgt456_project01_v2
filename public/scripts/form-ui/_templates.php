<?php header('Content-Type: text/plain'); ?>

@Template GroupElement
<div class="form-group">
    <div data-label class="label">%label%</div>
    <div data-error class="error"></div>
</div>

@Template TextElement
<div class="form-text">
    <label for="%id%">%label%</label>
    <input data-text type="text" id="%id%"/>
</div>

@Template TextareaElement
<div class="form-textarea">
    <label for="%id%">%label%</label>
    <textarea data-text id="%id%" rows="6"></textarea>
</div>

@Template RatingElement
<div class="form-rating">
    <label>%label%</label>
    <div data-options class="options">
        <div class="radio-item" data-radio-group>
            <input data-radio type="radio" name="%id%"/>
            <label class="radio-label" data-radio-label></label>
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
<div data-row class="form-row"></div>

@Template ReadonlyElement
<input type="hidden"/>