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
			<h2 class="page-title">Thank You</h2>
			<div class="thank-you-container">
				<div class="thank-you-header"><p>Thanks!</p></div>
				<div class="thank-you-message">{$thank_you_message|default:"We've recieved your request and will be in touch with you very soon!"}<br><br>Contact us at <b style="color: #444;">{$business->phone_number}</b></div>
			</div><!-- end thank-you-container -->

			<div class="clear"></div>

		</div><!-- end content -->

	</body>

</html>
