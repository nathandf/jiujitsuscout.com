<!DOCTYPE html>
<html>
	<head>
		{include file="includes/head/account-manager-head.tpl"}
		<link rel="stylesheet" type="text/css" href="{$HOME}public/css/partner-settings.css"/>
	</head>
	<body>
		{include file="includes/navigation/business-manager-login-menu.tpl"}
    	{include file="includes/navigation/business-manager-menu.tpl"}
		<div class="con-cnt-xxlrg inner-box first bg-white">
			{include file="includes/navigation/business-manager-settings-menu.tpl"}
			<div class="clear"></div>
			<div class="con-cnt-xlrg inner-pad-med">
				<div class="hr">
					<p class="txt-sml">Select which programs you offer so we can put your listings in front of the right audience</p>
				</div>
				{if !empty($error_messages.update_programs)}
					{foreach from=$error_messages.update_programs item=message}
						<div class="con-message-failure mat-hov cursor-pt --c-hide">
							<p class="user-message-body">{$message}</p>
						</div>
					{/foreach}
				{/if}
				<form action="" id="programs" method="post">
					<input type="hidden" name="token" value="{$csrf_token}">
					<input type="hidden" name="update_programs" value="{$csrf_token}">
					{foreach from=$programs item=program}
						<input type="checkbox" id="{$program->name}-cb" class="checkbox" name="programs[]" value="{$program->name}" {if $program->isset}checked="checked"{/if}/><label for="{$program->name}-cb"> {$program->nice_name}</label>
						<div class="clear last"></div>
					{/foreach}
					<div class="clear"></div>
					<input type="submit" class="btn" name="update-programs" value="Update Programs">
					<div class="clear"></div>
				</form>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</body>
</html>
