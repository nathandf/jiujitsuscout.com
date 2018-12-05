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
		<div class="hr-sml"></div>
		<p class="text-xlrg">Form fields</p>
		{foreach from=$embeddableFormElements item=element}
		<p class="text-lrg-heavy push-t-med">{$element->placement}. {$element->type->name|capitalize}</p>
		{foreachelse}
		-- No Form Elements Added Yet --
		{/foreach}
		<div class="hr-sml push-t-med"></div>
		<!-- <p class="push-b-med">Form Preview</p> -->
		{*$formHTML|unescape*}
		<div class="clear"></div>
	</div>
{/block}
