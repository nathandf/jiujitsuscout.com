<!DOCTYPE html>
<html>
	<head>
		 {include file="includes/head/account-manager-head.tpl"}
		 <link rel="stylesheet" type="text/css" href="{$HOME}css/landing-pages.css">
		 <link rel="stylesheet" type="text/css" href="{$HOME}css/account-manager-main.css">
		 <script src="{$HOME}{$JS_SCRIPTS}site-slug-updater.js" type="text/javascript"></script>
	</head>
	<body>
		{include file="includes/navigation/business-manager-login-menu.tpl"}
		{include file="includes/navigation/business-manager-marketing-menu.tpl"}
		<div>
			<div class="clear"></div>
			<div class="con con-cnt-xlrg first inner-pad-med">
				<a class="btn btn-inline bg-deep-blue text-med last" href="{$HOME}account-manager/business/groups/">< All Groups</a>
				{if !empty($error_messages.create_group)}
					{foreach from=$error_messages.create_group item=message}
						<div class="con-message-failure mat-hov cursor-pt --c-hide">
							<p class="user-message-body">{$message}</p>
						</div>
					{/foreach}
				{/if}
				<form method="post" action="{$HOME}account-manager/business/group/new">
					<input type="hidden" name="token" value="{$csrf_token}">
					<input type="hidden" name="create_group" value="{$csrf_token}">
					<div class="clear first"></div>
					<p><b>Group Name:</b></p>
					<input type="text" name="name" value="{$inputs.create_group.name|default:null}" class="inp field-sml" placeholder="Group name">
					<div class="clear first"></div>
					<b>Description: </b>
					<div class="clear"></div>
					<textarea style="text-indent: 0px; padding: 8px;" name="description" class="inp field-med" id="" cols="30" rows="10" placeholder="Describe what makes this group unique">{$inputs.create_group.description|default:null}</textarea>
					<div class="clear"></div>
					<input type="submit" class="btn btn-inline" value="Create group">
				</form>
			</div>
		</div><!-- end content -->
	</body>
</html>
