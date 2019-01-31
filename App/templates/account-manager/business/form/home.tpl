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
		{include file="includes/snippets/flash-messages.tpl"}
		<div class="clear push-t-med"></div>
		<p class="text-xlrg-heavy">{$form->name}</p>
		<div class="clear"></div>
		<a class="btn btn-inline bg-mango text-med push-t-med" href="{$HOME}account-manager/business/form/{$form->id}/edit">Edit Form</a>
		<a class="btn btn-inline bg-salmon text-med push-t-med" href="{$HOME}account-manager/business/form/{$form->id}/view">View Form</a>
		<div class="clear"></div>
		<p class="text-med">Form Code</p>
		<div contenteditable id="form-html" tabindex="-1" class="inp text-sml">
			{$form_code}
		</div>
		<div class="hr"></div>
		<form action="{$HOME}account-manager/business/form/{$form->id}/" method="post">
			<input type="hidden" name="token" value="{$csrf_token}">
			<input type="hidden" name="update_embeddable_form" value="{$csrf_token}">
			{if !empty($groups)}
				<h3 class="push-t-med">Groups</h3>
				<p class="text-med">Add leads to these groups when they sign up</p>
				<div class="clear push-t-med push-b-med"></div>
				{foreach from=$groups item=group name=group_loop}
				<input type="checkbox" id="groups{$smarty.foreach.group_loop.index}" class="cursor-pt checkbox" name="group_ids[]" value="{$group->id}" {if $group->isset}checked="checked"{/if}>
				<label for="groups{$smarty.foreach.group_loop.index}"><b>{$group->name}</b></label>
				<div class="clear"></div>
				{foreachelse}
				<p class="text-med">No Groups have been created yet. <a class="link tc-deep-blue" href="{$HOME}account-manager/business/group/new">Create your first group</a></p>
				{/foreach}
			{/if}
			{if !empty($sequence_templates)}
				<div class="hr"></div>
				<h3 class="push-t-med">Sequences</h3>
				<p class="text-med">Activate follow-up sequences when leads sign up on this form</p>
				<div class="clear push-t-med push-b-med"></div>
				{foreach from=$sequence_templates item=sequence_template name=sequence_loop}
				<input type="checkbox" id="sequences{$smarty.foreach.sequence_loop.index}" class="cursor-pt checkbox" name="sequence_template_ids[]" value="{$sequence_template->id}" {if $sequence_template->isset}checked="checked"{/if}>
				<label for="sequences{$smarty.foreach.sequence_loop.index}"><b>{$sequence_template->name}</b></label>
				<div class="clear"></div>
				{foreachelse}
				<p class="text-med">No Sequences have been created yet. <a class="link tc-deep-blue" href="{$HOME}account-manager/business/sequence/new">Create your first sequence</a></p>
				{/foreach}
			{/if}
			<input type="submit" class="btn btn-inline push-t-med" value="Update">
		</form>
	</div>
{/block}
