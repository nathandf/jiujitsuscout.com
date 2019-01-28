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
				<input type="text" name="name" class="inp inp-med-plus-plus" value="{$page->name}">
				<div class="clear push-t-sml"></div>
				<b>Slug:</b>
				<div class="clear"></div>
				<input type="text" name="slug" id="input-slug" class="inp inp-med-plus-plus" value="{$page->slug}">
				<p class="text-med">https://www.jiujitsuscout.com/martial-arts-gyms/{$business->id}/promo/<b id="slug">{$page->slug}</b></p>
				<div class="hr"></div>
				{if !empty($user_recipients)}
					<h3 class="push-t-med">Notification Recipients</h3>
					<p class="text-med">Send alerts to these users when a lead is captured</p>
					<div class="clear push-t-med push-b-med"></div>
					{foreach from=$user_recipients item=user name=user_loop}
					<input type="checkbox" id="users{$smarty.foreach.user_loop.index}" class="cursor-pt checkbox" name="user_ids[]" value="{$user->id}" {if $user->isset}checked="checked"{/if}>
					<label for="users{$smarty.foreach.user_loop.index}"><b>{$user->getFullName()}</b></label>
					<div class="clear"></div>
					{foreachelse}
				{/foreach}
				<div class="hr"></div>
				{/if}
				{if !empty($facebook_pixels)}
					<h3 class="push-t-med">Facebook Pixels</h3>
					<p class="text-med">Track user action on this landing page with Facebook Pixels</p>
					<div class="clear push-t-med push-b-med"></div>
					{foreach from=$facebook_pixels item=facebook_pixel name=pixel_loop}
					<input type="checkbox" id="pixels{$smarty.foreach.pixel_loop.index}" class="cursor-pt checkbox" name="facebook_pixel_ids[]" value="{$facebook_pixel->id}" {if $facebook_pixel->isset}checked="checked"{/if}>
					<label for="pixels{$smarty.foreach.pixel_loop.index}"><b>{$facebook_pixel->name}</b></label>
					<div class="clear"></div>
					{foreachelse}
					<p class="text-med">No pixel have been added to this business. <a class="link tc-deep-blue" href="{$HOME}account-manager/business/assets/facebook-pixels">Add a Facebook Pixel</a></p>
				{/foreach}
				<div class="hr"></div>
				{/if}
				{if $groups}
					<h3 class="push-t-med">Groups</h3>
					<p class="text-med">Assign leads from this landing page to groups.</p>
					<div class="clear push-t-med push-b-med"></div>
					{foreach from=$groups item=group name="group_loop"}
						<input type="checkbox" id="groups{$smarty.foreach.group_loop.index}" class="cursor-pt checkbox" name="group_ids[]" value="{$group->id}" {if $group->isset}checked="checked"{/if}>
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
					<input type="checkbox" id="sequences{$smarty.foreach.sequence_loop.index}" class="cursor-pt checkbox" name="sequence_template_ids[]" value="{$sequence_template->id}" {if $sequence_template->isset}checked="checked"{/if}>
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
