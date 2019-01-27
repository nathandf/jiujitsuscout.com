{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}
	<link rel="stylesheet" type="text/css" href="{$HOME}public/css/partner-settings.css"/>
{/block}

{block name="bm-body"}
	{include file="includes/navigation/marketing-sub-menu.tpl"}
	<div class="con-cnt-xlrg push-t-med encapsulate bg-white">
		{include file="includes/navigation/business-manager-assets-inner-menu.tpl"}
		<div class="inner-pad-med">
			{if !empty($error_messages.facebook_pixel)}
				{foreach from=$error_messages.facebook_pixel item=message}
					<div class="con-message-failure mat-hov cursor-pt --c-hide">
						<p class="user-message-body">{$message}</p>
					</div>
				{/foreach}
			{/if}
			{if !empty($error_messages.delete.facebook_pixel)}
				{foreach from=$error_messages.delete.facebook_pixel item=message}
					<div class="con-message-failure mat-hov cursor-pt --c-hide">
						<p class="user-message-body">{$message}</p>
					</div>
				{/foreach}
			{/if}
			{include file="includes/snippets/flash-messages.tpl"}
			<div class="clear"></div>
			<h2 class="">Facebook Pixels</h2>
			<p class="text-sml">Track user action on your landing pages with Facebook Pixels</p>
			{foreach from=$facebookPixels item=facebookPixel name=pixel_loop}
			{if $smarty.foreach.pixel_loop.iteration == 1}
			<div class="clear hr-sml"></div>
			{/if}
			<div class="push-t-sml inner-pad-sml" style="box-sizing: border-box; border-radius: 3px; border: 2px solid #CCCCCC;">
				<form method="post" action="">
					<input type="hidden" name="delete_pixel" value="{$csrf_token}">
					<input type="hidden" name="token" value="{$csrf_token}">
					<input type="hidden" name="facebook_pixel_id" value="{$facebookPixel->id}">
					<button class="btn btn-inline bg-red tc-white cursor-pt mat-hov floatright --c-trash"><i class="fa fa-trash" aria-hidden="true"></i></button>
				</form>
				<p class="text-med">{$facebookPixel->name}</p>
				<p class="text-sml-heavy">{$facebookPixel->facebook_pixel_id}</p>
			</div>
			{/foreach}
			<div class="clear hr-sml"></div>
			<h3 class="push-t-med">Add a Facebook Pixel</h3>
			<form action="" method="post">
				<input type="hidden" name="token" value="{$csrf_token}">
				<input type="hidden" name="add_pixel" value="{$csrf_token}">
				<p class="text-sml push-t-med">Pixel Name:</p>
				<input type="text" name="name" class="inp inp-med-plus-plus" placeholder="Pixel Name">
				<p class="text-sml push-t-sml">Pixel ID:</p>
				<input type="text" name="facebook_pixel_id" class="inp inp-med-plus-plus" placeholder="Facebook Pixel ID">
				<div class="clear"></div>
				<button type="submit" class="btn btn-inline push-t-med" name="update-pixel"><i class="fa fa-plus" aria-hidden="true"></i> Add Pixel</button>
				<div class="clear"></div>
			</form>
		</div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
{/block}
