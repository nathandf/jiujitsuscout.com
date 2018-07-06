<!DOCTYPE html>
<html>
	<head>
		{include file="includes/head/account-manager-head.tpl"}
		<link rel="stylesheet" type="text/css" href="{$HOME}css/user.css"/>
		<link rel="stylesheet" type="text/css" href="{$HOME}css/account-manager-main.css"/>
		<script rel="text/javascript" src="{$HOME}{$JS_SCRIPTS}lead.js"></script>
	</head>
	<body>
		{include file="includes/navigation/business-manager-login-menu.tpl"}
	    {include file="includes/navigation/business-manager-menu.tpl"}
	    <div class="con-cnt-xxlrg">
			<div class="con-cnt-xxlrg encapsulate first">
				<div class="bg-green">
					<div class="col col-3"><p class="col-title tc-white">Account Type</p></div>
					<div class="col col-3"><p class="col-title tc-white">Total Leads</p></div>
					<div class="col col-3-last"><p class="col-title tc-white">Listing Type</p></div>
					<div class="clear"></div>
				</div>
				<div class="row-seperator"></div>
				<div class="bg-white">
					<div class="col col-3"><p class="col-title">{$account_type->name|capitalize}{if $account_type->id != 4}<br><a class="link text-sml tc-mango" target="_blank" href="{$HOME}account-manager/upgrade"><b>Upgrade</b></a>{/if}</p></div>
					<div class="col col-3"><p class="col-title">{$leads|@count}</p></div>
					<div class="col col-3-last"><p class="col-title">{$business->listing_type|capitalize}</p></div>
					<div class="clear"></div>
				</div>
			</div>
      <div class="col col-2 encapsulate bg-white first">
        <h4 class="h4 first">Lead Management</h4>
        <div class="con-cnt-fit funnel first">
          <a href="{$HOME}account-manager/business/leads" class="f-lvl funnel-level-1 funnel-bg-2 mat-hov">Leads<br>{$leads|@count}</a>
          <a href="{$HOME}account-manager/business/appointments" class="f-lvl funnel-level-2 funnel-bg-5 mat-hov">Appointments<br>{$appointments|@count}</a>
          <a href="{$HOME}account-manager/business/trials" class="f-lvl funnel-level-3 funnel-bg-3 mat-hov">Trials<br>{$trials|@count}</a>
          <a href="{$HOME}account-manager/business/members" class="f-lvl funnel-level-4 funnel-level-last mat-hov">Members<br>{$members|@count}</a>
        </div>
      </div>
			<div class="col col-2-last encapsulate bg-white first">
        <h4 class="h4 first">Marketing Management</h4>
        <div class="con-cnt-fit funnel first">
          <a href="{$HOME}account-manager/business/landing-pages/" class="btn btn-inline bg-deep-blue push-r">Landing Pages</a>
					<a href="{$HOME}account-manager/business/groups/" class="btn btn-inline bg-deep-blue push-r">Groups</a>
					<a href="{$HOME}account-manager/business/campaigns/" class="btn btn-inline bg-deep-blue">Campaigns</a>
        </div>
      </div>
      <div class="clear"></div>
    </div>
		<div class="clear"></div>
	</body>
</html>
