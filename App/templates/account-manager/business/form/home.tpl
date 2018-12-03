{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}
	<link rel="stylesheet" type="text/css" href="{$HOME}public/css/landing-pages.css">
	<script src="{$HOME}{$JS_SCRIPTS}site-slug-updater.js" type="text/javascript"></script>
{/block}

{block name="bm-body"}
	{include file="includes/navigation/marketing-sub-menu.tpl"}
	<div class="clear"></div>
	<div class="con-cnt-xlrg push-t-med inner-pad-med">
		<a class="btn btn-inline bg-deep-blue text-med push-b-med" href="{$HOME}account-manager/business/forms/">< Back</a>
		<div class="clear push-t-med"></div>
		<p class="text-xlrg-heavy">{$form->name}</p>
		<div class="clear"></div>
		<a class="btn btn-inline bg-deep-blue text-med push-t-med" href="{$HOME}account-manager/business/form/{$form->id}/edit">Edit Form</a>
		<div class="clear"></div>
		<div contenteditable id="form-html" class="inp textarea" style="text-align: left; height: 300px; width: 100%; overflow-y: scroll; white-space: pre-wrap;">
			{if $form->elements|@count < 1}
			This form doesn't have any elements yet.
			{else}
			{$formHTML}
			{/if}
		</div>
		<div class="clear"></div>
	</div>
{/block}
