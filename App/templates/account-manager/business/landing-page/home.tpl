<!DOCTYPE html>
<html>
	<head>
		 {include file="includes/head/account-manager-head.tpl"}
		 <link rel="stylesheet" type="text/css" href="{$HOME}public/css/landing-pages.css">
		 <link rel="stylesheet" type="text/css" href="{$HOME}public/css/account-manager-main.css">
		 <script src="{$HOME}{$JS_SCRIPTS}site-slug-updater.js" type="text/javascript"></script>
	</head>
	<body>
		{include file="includes/navigation/business-manager-login-menu.tpl"}
		{include file="includes/navigation/business-manager-marketing-menu.tpl"}
		<div>
			<div class="clear"></div>
			<div class="con con-cnt-xlrg first inner-pad-med">
				<a class="btn btn-inline bg-deep-blue text-med" href="{$HOME}account-manager/business/landing-pages/">< Landing Pages</a>
				<a class="btn btn-inline text-med floatright" href="{$HOME}account-manager/business/landing-page/{$page->id}/preview">Preview ></a>
				<div class="clear first"></div>
				{if !empty($error_messages.update_landing_page)}
					{foreach from=$error_messages.update_landing_page item=message}
						<div class="con-message-failure mat-hov cursor-pt --c-hide">
							<p class="user-message-body">{$message}</p>
						</div>
					{/foreach}
				{/if}
				<form action="{$HOME}account-manager/business/landing-page/{$page->id}/" method="post">
					<input type="hidden" name="token" value="{$csrf_token}">
					<input type="hidden" name="update_landing_page" value="{$csrf_token}">
					<b>Name:</b>
					<div class="clear"></div>
					<input type="text" name="name" class="inp field-sml" value="{$page->name}">
					<div class="clear"></div>
					<b>Slug:</b>
					<div class="clear"></div>
					<input type="text" name="slug" id="input-slug" class="inp field-sml" value="{$page->slug}">
					<p class="text-med">https://www.jiujitsuscout.com/martial-arts-gyms/{$business->site_slug}/promo/<b id="slug">{$page->slug}</b></p>
					<div class="hr"></div>
					{if $business->facebook_pixel_id != null}
					<h3 class="first last">Tracking</h3>
					<div class="clear"></div>
					<label class="first cursor-pt" for="facebook-pixel-id">Track with Facebook Pixel </label>
					<input type="checkbox" id="facebook-pixel-id" class="cursor-pt" name="facebook_pixel_track" value="{$business->facebook_pixel_id}" {if $facebook_pixel_active}checked="checked"{/if}>
					<div class="hr"></div>
					{/if}
					{if $groups}
						<h3 class="first last">Groups</h3>
						<div class="clear first"></div>
						<label for="groups">Assign leads from this landing page to groups:</label>
						<div class="clear first last"></div>
						{foreach from=$groups item=group name="group_loop"}
							<input type="checkbox" id="groups{$smarty.foreach.group_loop.index}" class="cursor-pt" name="group_ids[]" value="{$group->id}" {if $group->isset}checked="checked"{/if}>
							<label for="groups"><b>{$group->name}</b></label>
							<div class="clear"></div>
						{/foreach}
						<div class="hr"></div>
					{/if}
					<input type="submit" class="btn btn-inline" name="update_landing_page" value="Update">
				</form>
			<div>
		</div><!-- end content -->
	</body>
</html>
