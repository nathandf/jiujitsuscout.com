{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}
	<script type="text/javascript" src="{$HOME}{$JS_SCRIPTS}form-editor.js"></script>
{/block}

{block name="bm-body"}
	{include file="includes/navigation/marketing-sub-menu.tpl"}
	<div class="clear"></div>
	<div class="con-cnt-xlrg push-t-med inner-pad-med">
		<!-- Form to add a field -->
		<form id="add-field" method="post" action="{$HOME}account-manager/business/form/{$form->id}/edit">
			<input type="hidden" name="token" value="{$csrf_token}">
			<input type="hidden" name="add_field" value="{$csrf_token}">
			<input type="hidden" name="placement" value="{$new_element_placement}">
			<input type="hidden" name="required" value="true" class="element-required-input">
			<input id="embeddable-form-element-type-id-input" type="hidden" name="embeddable_form_element_type_id" value="">
		</form>
		<!-- Form to bump a fields placement -->
		<form id="bump" method="post" action="{$HOME}account-manager/business/form/{$form->id}/edit">
			<input type="hidden" name="token" value="{$csrf_token}">
			<input type="hidden" name="bump" value="{$csrf_token}">
			<input type="hidden" name="required" value="true" class="element-required-input">
			<input type="hidden" name="embeddable_form_element_id" value="">
		</form>
		<a class="btn btn-inline bg-deep-blue text-med push-b-med" href="{$HOME}account-manager/business/form/{$form->id}/">< Back to form</a>
		<div class="clear push-t-med"></div>
		<p class="text-xlrg-heavy">{$form->name}</p>
		<div class="hr-sml push-b-sml"></div>
		<p class="text-sml">Add a new field to this form</p>
		<div class="clear push-t-med"></div>
		{if !empty($error_messages.add_field)}
			{foreach from=$error_messages.add_field item=message}
				<div class="con-message-failure mat-hov cursor-pt --c-hide">
					<p class="user-message-body">{$message}</p>
				</div>
			{/foreach}
		{/if}
		<input id="required-checkbox" checked="checked" type="checkbox" name="required-checkbox" class="checkbox"><label for="required-checkbox">Make new field required</label>
		<div class="clear"></div>
		<select class="inp field-med cursor-pt" name="" id="element-selector">
			<option value="" selected="selected" hidden="hidden">-- Add a field --</option>
			{foreach from=$availableEmbeddableFormElementTypes item=embeddableFormElementType}
			{if $embeddableFormElementType->name != "submit"}
			<option class="element-type-option" id="{$embeddableFormElementType->id}" value="{$embeddableFormElementType->id}">{$embeddableFormElementType->name|capitalize}</option>
			{/if}
			{/foreach}
		</select>
		<div class="clear"></div>
		<div class="hr-sml push-t-med"></div>
		<p class="push-b-med">Form Preview</p>
		<script type="text/javascript" src="{$HOME}public/static/js/embeddable-form.js"></script>
		<div id="display-form" class="EmbeddableFormWidgetByJiuJitsuScout__form-container">
			{if $embeddableFormElements|@count < 0}
			<p>No Fields added to your form yet</p>
			{else}
			<p class="EmbeddableFormWidgetByJiuJitsuScout__form-offer">{$form->offer}</p>
			<br/>
			{foreach from=$embeddableFormElements item=$element name="element_loop"}
			<label class="EmbeddableFormWidgetByJiuJitsuScout__form-input-label" for="">{$element->type->name|capitalize}</label>
			{if $element->required}<span class="EmbeddableFormWidgetByJiuJitsuScout__required">*</span>{/if}
			<br/>
			{if $element->type->name != 'message'}
			<input autocomplete="off" class="EmbeddableFormWidgetByJiuJitsuScout__form-input" name="" type=""/>
			{else}
			<textarea autocomplete="off" class="EmbeddableFormWidgetByJiuJitsuScout__form-textarea" name="" type=""/></textarea>
			{/if}
			<br/>
			{foreachelse}
			<p class="text-sml">-- No Fields Added Yet --</p>
			{/foreach}
			<br/>
			<button type="submit" class="EmbeddableFormWidgetByJiuJitsuScout__form-submit-button EmbeddableFormWidgetByJiuJitsuScout__material-hover"/>Get Offer Now ></button>
			{/if}
		</div>
		<div class="clear"></div>
	</div>
{/block}
