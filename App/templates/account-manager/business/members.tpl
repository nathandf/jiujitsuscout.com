<!DOCTYPE html>
<html>
	<head>
		{include file="includes/head/account-manager-head.tpl"}
		<link rel="stylesheet" type="text/css" href="{$HOME}public/css/account-manager-main.css"/>
	</head>
	<body>
		{include file="includes/navigation/business-manager-login-menu.tpl"}
	    {include file="includes/navigation/business-manager-menu.tpl"}
		<div class="con-cnt-xxlrg first last inner-pad-med">
			<h2>Members</h2>
			<a href="{$HOME}account-manager/business/member/new" class="btn btn-inline members mat-hov first"><span class="text-med">Add Member <i class="fa fa-plus" aria-hidden="true"></i></span></a>
			<div class="clear"></div>
			<!-- <input type="search" class="inp field-med first last" placeholder="Search">
			<div class="clear"></div> -->
			<div id="lead-tag-container">
				<p class='results_count_message'>Showing ({$members|@count}) Results</p>
				{foreach from=$members item=member}
					<a href="{$HOME}account-manager/business/member/{$member->id}/" id="member{$member->id}" class="lead-tag first mat-hov">
						<span class="lead-icon {cycle values="icon-c-1,icon-c-2,icon-c-3,icon-c-4"}">{$member->first_name|substr:0:1|upper}</span>
						<div class="lead-data">
							<p class="lead-name">{$member->first_name} {$member->last_name}</p>
							<p>{$member->phone_number|default:"Number: none"}</p>
							<p>{$member->email|default:"Email: none"}</p>
						</div>
					</a>
					<div class="clear"></div>
				{/foreach}
			</div>
			<div class="clear"></div>
		</div>
  </body>
</html>
