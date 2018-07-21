<!DOCTYPE html>
<html>
	<head>
		 {include file="includes/head/account-manager-head.tpl"}
		 <link rel="stylesheet" type="text/css" href="{$HOME}public/css/landing-pages.css">
		 <link rel="stylesheet" type="text/css" href="{$HOME}public/css/account-manager-main.css">
	</head>
	<body>
		{include file="includes/navigation/business-manager-login-menu.tpl"}
		{include file="includes/navigation/business-manager-marketing-menu.tpl"}
		<div>
			<div class="clear"></div>
			<div class="con con-cnt-xlrg first inner-pad-med">
				<h2 class="first">Landing Pages</h2>
				<p class="text-sml first">Capture leads with landing pages you create! The JiuJitsuScout Landing Page builder makes it super easy to build effective landing pages that drive action and capture leads.</p>
				<div class="hr-sml"></div>
				<a href="{$HOME}account-manager/business/landing-page/choose-template" class="btn btn-inline first mat-hov"><span class="text-med">Create Landing Page <i class="fa fa-plus" aria-hidden="true"></i></span></a>
				{foreach from=$pages item=page}
				<div class="landing-page-tag">
					<div class="landing-page-icon bg-deep-blue push-r floatleft"><i class="fa fa-2x fa-globe" aria-hidden="true"></i></div>
					<div class="landing-page-info floatleft">
						<p><b>{$page->name}</b></p>
						<div class="clear"></div>
						<p><b>Slug: </b>{$page->slug}</p>
					</div>
					<div class="m-clear"></div>
					<div class="action-buttons">
						<a class="btn btn-inline action-button text-med floatright" href="{$HOME}account-manager/business/landing-page/{$page->id}/preview">Preview</a>
						<a class="btn btn-inline action-button push-r bg-forest text-med floatright" href="{$HOME}account-manager/business/landing-page/{$page->id}/">Edit</a>
					</div>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
				{/foreach}
			<div>
		</div><!-- end content -->
	</body>
</html>
