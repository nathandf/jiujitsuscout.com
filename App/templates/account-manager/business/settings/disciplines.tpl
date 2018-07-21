<!DOCTYPE html>
<html>
	<head>
		{include file="includes/head/account-manager-head.tpl"}
		<link rel="stylesheet" type="text/css" href="{$HOME}public/css/partner-settings.css"/>
	</head>
	<body>
		{include file="includes/navigation/business-manager-login-menu.tpl"}
    	{include file="includes/navigation/business-manager-menu.tpl"}
		<div class="con-cnt-xxlrg inner-box bg-white first">
			{include file="includes/navigation/business-manager-settings-menu.tpl"}
			<div class="clear"></div>
			<div class="con-cnt-xlrg inner-pad-med">
				<h2 class="h2 push-t-med">Disciplines</h2>
				<div class="hr-sml">
					<p class="text-sml">Let customers know which classes you offer. Your listing will show up locally in the search results for those specific classes.</p>
				</div>
				{if !empty($error_messages.update_disciplines)}
					{foreach from=$error_messages.update_disciplines item=message}
						<div class="con-message-failure mat-hov cursor-pt --c-hide">
							<p class="user-message-body">{$message}</p>
						</div>
					{/foreach}
				{/if}
				<h4 class="h4 push-t-med push-b-med">Which disciplines do you offer at your gym? Select all that apply.</h4>
					<form id="disciplines" action="#disciplines" method="post">
						<input type="hidden" name="token" value="{$csrf_token}">
						<input type="hidden" name="update_disciplines" value="{$csrf_token}">
						<div class="check-box-container">
							{foreach from=$disciplines item=discipline}
							<input type="checkbox" id="{$discipline->name}-cb" class="checkbox" name="disciplines[]" value="{$discipline->id}" {if $discipline->isset}checked="checked"{/if}/><label for="{$discipline->name}-cb"> {$discipline->nice_name}</label>
							<div class="clear last"></div>
							{/foreach}
				    	</div>
						<div class="clear"></div>
						<input type="submit" class="btn btn-inline push-t-med" value="Update Available Classes">
					</form>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</body>
</html>
