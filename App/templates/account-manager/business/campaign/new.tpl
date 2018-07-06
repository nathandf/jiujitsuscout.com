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
				<a class="btn btn-inline bg-deep-blue text-med last" href="{$HOME}account-manager/business/campaigns/">< All Campaigns</a>
				{if !empty($error_messages.create_campaign)}
					{foreach from=$error_messages.create_campaign item=message}
						<div class="con-message-failure mat-hov cursor-pt --c-hide">
							<p class="user-message-body">{$message}</p>
						</div>
					{/foreach}
				{/if}
				<form method="get" action="{$HOME}account-manager/business/campaign/new">
					<input type="hidden" name="token" value="{$csrf_token}">
					<input type="hidden" name="create_campaign" value="true">
					<div class="clear first"></div>
					<input type="hidden" name="campaign_type_id" value="{$campaign_type_id}">
					<p><b>Campaign Name:</b></p>
					<input type="text" name="name" value="{$inputs.create_campaign.name|default:null}" class="inp field-sml" placeholder="Campaign name">
					<div class="clear first"></div>
					<b>Description: </b>
					<div class="clear"></div>
					<textarea style="text-indent: 0px; padding: 8px;" name="description" class="inp field-med" id="" cols="30" rows="10" placeholder="Campaign Description">{$inputs.create_campaign.description|default:null}</textarea>
					<div class="clear"></div>
					<p><b>Start Date:</b></p>
					{html_select_date class="inp field-xsml-plus cursor-pt first" prefix='start' start_year='-1' end_year='+3'}
					<div class="clear"></div>
					<p><b>End Date:</b></p>
					{html_select_date class="inp field-xsml-plus cursor-pt first"  prefix='end' start_year='-1' end_year='+3'}
					<div class="clear"></div>
					<input type="submit" class="btn btn-inline" value="Create campaign">
				</form>
			<div>
		</div><!-- end content -->
	</body>
</html>
