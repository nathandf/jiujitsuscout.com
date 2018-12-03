{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}
{/block}

{block name="bm-body"}
	{include file="includes/navigation/marketing-sub-menu.tpl"}
	<div class="clear"></div>
	<div class="con-cnt-xlrg push-t-med inner-pad-med">
		<a class="btn btn-inline bg-deep-blue text-med push-b-med" href="{$HOME}account-manager/business/form/{$form->id}/">< Back to form</a>
		<div class="clear push-t-med"></div>
		<p class="text-xlrg-heavy">{$form->name}</p>
		<p class="text-sml">Add and edit fields on your form</p>
		<div class="clear push-t-med"></div>
		<select class="inp field-med cursor-pt" name="" id="embbeddable_form_element_types">
			<option value="" selected="selected" hidden="hidden">-- Add a field --</option>
			{foreach from=$embeddableFormElementTypes item=embeddableFormElementType}
			{if $embeddableFormElementType->name != "submit"}
			<option id="{$embeddableFormElementType->id}" value="{$embeddableFormElementType->id}">{$embeddableFormElementType->name|capitalize}</option>
			{/if}
			{/foreach}
		</select>
		<div class="clear push-t-med"></div>
		<p>Form Preview</p>
		<div class="hr-sml push-b-med"></div>
		<script type="text/javascript" src="{$HOME}public/static/js/embeddable-form.js"></script>
		<div id="display-form" class="EmbeddableFormWidgetByJiuJitsuScout__form-container">
			{if $embeddableFormElements|@count < 0}
			<p>No Fields added to your form yet</p>
			{else}
			<p class="EmbeddableFormWidgetByJiuJitsuScout__form-offer">{$form->offer}</p>
			<br/>
			{foreach from=$embeddableFormElements item=$element name="element_loop"}
			<label class="EmbeddableFormWidgetByJiuJitsuScout__form-input-label" for="">{$element->type->name|capitalize}</label>
			<br/>
			<input autocomplete="off" class="EmbeddableFormWidgetByJiuJitsuScout__form-input" name="" type=""/>
			<br/>
			{if !$smarty.foreach.element_loop.last}
			<br/>
			{else}
				{if $element->type}
				<br/>
				<button type="submit" class="EmbeddableFormWidgetByJiuJitsuScout__form-submit-button EmbeddableFormWidgetByJiuJitsuScout__material-hover"/>Get Offer Now ></button>
				{/if}
			{/if}
			{foreachelse}
			<p class="text-sml">-- No Fields Added Yet --</p>
			{/foreach}
			{/if}
		</div>
		<div class="clear"></div>
	</div>
{/block}
