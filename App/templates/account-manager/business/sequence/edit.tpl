{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}
	<link rel="stylesheet" type="text/css" href="{$HOME}public/css/sequence.css">
	<script src="{$HOME}{$JS_SCRIPTS}site-slug-updater.js" type="text/javascript"></script>
{/block}

{block name="bm-body"}
	{include file="includes/navigation/marketing-sub-menu.tpl"}
	<div class="clear"></div>
	<div>
		<div class="clear"></div>
		<div class="con con-cnt-xlrg push-t-med inner-pad-med">
			<a class="tc-deep-blue link text-med-heavy push-b-med" href="{$HOME}account-manager/business/sequences/">Sequences</a> > <a class="tc-deep-blue link text-med-heavy push-b-med" href="{$HOME}account-manager/business/sequence/{$sequence->id}/">{$sequence->name}</a> > <span class="text-med-heavy">Edit</span>
			<div class="hr-sml"></div>
			{include file="includes/snippets/flash-messages.tpl"}
			{if !empty($error_messages.update_sequence)}
				{foreach from=$error_messages.update_sequence item=message}
					<div class="con-message-failure mat-hov cursor-pt --c-hide">
						<p class="user-message-body">{$message}</p>
					</div>
				{/foreach}
			{/if}
			<form method="post" action="{$HOME}account-manager/business/sequence/{$sequence->id}/edit">
				<input type="hidden" name="token" value="{$csrf_token}">
				<input type="hidden" name="update_sequence" value="{$csrf_token}">
				<div class="clear push-t-med"></div>
				<p class="push-t-med"><b>Name:</b></p>
				<input style="padding: 3px;" type="text" name="name" value="{$sequence->name}" class="inp" placeholder="">
				<div class="clear push-t-med"></div>
				<p><b>Description:</b></p>
				<textarea name="description" class="inp textarea" placeholder="">{$sequence->description}</textarea>
				<div class="clear push-t-med"></div>
				<input type="submit" class="btn btn-inline" value="Update Sequence">
			</form>
		</div>
	</div><!-- end content -->
{/block}
