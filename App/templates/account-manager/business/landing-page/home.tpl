{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}
	<link rel="stylesheet" type="text/css" href="{$HOME}public/css/landing-pages.css">
	<script src="{$HOME}{$JS_SCRIPTS}site-slug-updater.js" type="text/javascript"></script>
{/block}

{block name="bm-body"}
	{include file="includes/navigation/marketing-sub-menu.tpl"}
	<div>
		<div class="clear"></div>
		<div class="con con-cnt-xlrg push-t-med inner-pad-med">
			<a class="btn btn-inline bg-deep-blue text-med" href="{$HOME}account-manager/business/landing-pages/">< Landing Pages</a>
			<a class="btn btn-inline text-med floatright" href="{$HOME}account-manager/business/landing-page/{$page->id}/preview">Preview ></a>
			<div class="clear push-t-med"></div>
			{if !empty($error_messages.update_landing_page)}
				{foreach from=$error_messages.update_landing_page item=message}
					<div class="con-message-failure mat-hov cursor-pt --c-hide">
						<p class="user-message-body">{$message}</p>
					</div>
				{/foreach}
			{/if}
			{include file="includes/snippets/flash-messages.tpl"}
			<form action="{$HOME}account-manager/business/landing-page/{$page->id}/" method="post">
				<input type="hidden" name="token" value="{$csrf_token}">
				<input type="hidden" name="update_landing_page" value="{$csrf_token}">
				<b>Name:</b>
				<div class="clear"></div>
				<input type="text" name="name" class="inp" value="{$page->name}">
				<div class="clear push-t-med"></div>
				<b>Slug:</b>
				<div class="clear"></div>
				<input type="text" name="slug" id="input-slug" class="inp" value="{$page->slug}">
				<p class="text-med">https://www.jiujitsuscout.com/martial-arts-gyms/{$business->id}/promo/<b id="slug">{$page->slug}</b></p>
				<div class="hr"></div>
				{if $business->facebook_pixel_id != null}
				<h3 class="push-t-med">Tracking</h3>
				<div class="clear"></div>
				<input type="checkbox" id="facebook-pixel-id" class="cursor-pt" name="facebook_pixel_track" value="{$business->facebook_pixel_id}" {if $facebook_pixel_active}checked="checked"{/if}>
				<label class="push-t-med cursor-pt" for="facebook-pixel-id">Track with Facebook Pixel </label>
				<div class="hr"></div>
				{/if}
				{if $groups}
					<h3 class="push-t-med">Groups</h3>
					<p class="text-med">Assign leads from this landing page to groups.</p>
					<div class="clear push-t-med push-b-med"></div>
					{foreach from=$groups item=group name="group_loop"}
						<input type="checkbox" id="groups{$smarty.foreach.group_loop.index}" class="cursor-pt" name="group_ids[]" value="{$group->id}" {if $group->isset}checked="checked"{/if}>
						<label for="groups"><b>{$group->name}</b></label>
						<div class="clear"></div>
					{/foreach}
					<div class="hr"></div>
				{/if}
				{if !empty($sequence_templates)}
					<h3 class="push-t-med">Sequences</h3>
					<p class="text-med">Activate follow-up sequences when leads sign up on this landing page</p>
					<div class="clear push-t-med push-b-med"></div>
					{foreach from=$sequence_templates item=sequence_template name=sequence_loop}
					<input type="checkbox" id="sequences{$smarty.foreach.sequence_loop.index}" class="cursor-pt" name="sequence_template_ids[]" value="{$sequence_template->id}" {if $sequence_template->isset}checked="checked"{/if}>
					<label for="sequences{$smarty.foreach.sequence_loop.index}"><b>{$sequence_template->name}</b></label>
					<div class="clear"></div>
					{foreachelse}
					<p class="text-med">No Sequences have been created yet. <a class="link tc-deep-blue" href="{$HOME}account-manager/business/sequence/new">Create your first sequence</a></p>
				{/foreach}
				{/if}
				<input type="submit" class="btn btn-inline push-t-med" name="update_landing_page" value="Update">
			</form>
		</div>
	</div><!-- end content -->
{/block}
