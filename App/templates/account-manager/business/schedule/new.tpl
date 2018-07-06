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
				<a class="btn btn-inline bg-dark-creamsicle text-med last" href="{$HOME}account-manager/business/schedules/">< All Schedules</a>
				{if !empty($error_messages.create_schedule)}
					{foreach from=$error_messages.create_schedule item=message}
						<div class="con-message-failure mat-hov cursor-pt --c-hide">
							<p class="user-message-body">{$message}</p>
						</div>
					{/foreach}
				{/if}
				<form method="post" action="{$HOME}account-manager/business/schedule/new">
					<input type="hidden" name="token" value="{$csrf_token}">
					<input type="hidden" name="create_schedule" value="{$csrf_token}">
					<div class="clear first"></div>
					<p><b>Schedule Name:</b></p>
					<input type="text" name="name" value="{$inputs.create_schedule.name|default:null}" class="inp field-sml" placeholder="Schedule name">
					<div class="clear first"></div>
					<b>Description: </b>
					<div class="clear"></div>
					<textarea style="text-indent: 0px; padding: 8px;" name="description" class="inp field-med" id="" cols="30" rows="10" placeholder="Describe what makes this schedule unique">{$inputs.create_schedule.description|default:null}</textarea>
					<div class="clear"></div>
					<input type="submit" class="btn btn-inline push-t-med" value="Create schedule">
				</form>
			</div>
		</div><!-- end content -->
	</body>
</html>
