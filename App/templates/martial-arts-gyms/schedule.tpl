<!DOCTYPE html>
<html>
	<head>
		{include file='includes/head/main-head.tpl'}
		<link rel="stylesheet" type="text/css" href="{$HOME}css/ma-profile-main.css"/>
		{$facebook_pixel|default:""}
	</head>
	<body>
		{include file='includes/navigation/martial-arts-gym-nav-mobile.tpl'}
		<div id="content" class="" itemscope itemtype="http://schema.org/LocalBusiness">
			{include file='includes/snippets/profile-title-bar.tpl'}
			{include file='includes/navigation/martial-arts-gym-nav.tpl'}
			<h2 class="page-title">Schedule</h2>
			<div class="schedule-container">
			</div><!-- end schedule-container -->
			{include file='includes/forms/sidebar-promo-form.tpl'}
			<div class="clear"></div>
			<div id="school-info-box">
				<p>Come by for your <a href="{$HOME}martial-arts-gyms/{$business->site_slug}/free-class">free trial class!</a></p>
				{include file='includes/snippets/js-google-map.tpl'}
				<div class="clear"></div>
				<p>{$business->address_1}, {$business->city}, {$business->region} {$business->postal_code}</p>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
		</div><!-- end content -->
	</body>
</html>
