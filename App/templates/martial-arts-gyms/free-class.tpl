<!DOCTYPE html>
<html>
	<head>
		{include file='includes/head/main-head.tpl'}
		<link rel="stylesheet" type="text/css" href="{$HOME}css/ma-profile-main.css"/>
		{$facebook_pixel|default:""}
	</head>
	<body>

		<div id="content" class="" itemscope itemtype="http://schema.org/LocalBusiness">
			{include file='includes/snippets/profile-title-bar.tpl'}
			{include file='includes/navigation/martial-arts-gym-nav.tpl'}
			<h2 class="page-title">Free Class</h2>
			<div class="free-class-container">
				<div class="free-class-header"><p>Reserve your free class below!</p></div>
				<form action="{$HOME}martial-arts-gyms/{$business->site_slug}/free-class" method="post">
					{if !empty($error_messages.free_class)}
						{foreach from=$error_messages.free_class item=message}
							<div class="con-message-failure mat-hov cursor-pt --c-hide">
								<p class="user-message-body">{$message}</p>
							</div>
						{/foreach}
					{/if}
					<input type="hidden" name="token" value="{$csrf_token}">
					<p class="free-class-input-label">Name:</p>
					<input type="text" name="name" value="{$inputs.free_class.name|default:null}" class="free-class-input" >
					<div class="clear"></div>
					<p class="free-class-input-label">Email:</p>
					<input type="text" value="{$inputs.free_class.email|default:null}" name="email" class="free-class-input" >
					<div class="clear"></div>
					<p class="free-class-input-label">Phone Number:</p>
					<input type="text" name="number" value="{$inputs.free_class.number|default:null}" class="free-class-input" >
					<div class="clear"></div>
					<input type="submit" name="free_class" class="free-class-form-button" value="Reserve my free class!">
					<p class="free-class-form-ps"><b>P.S.</b> We want to give you the best martial arts experience possible. That's why we're giving you a risk-free class at no expense, so fill out the form and come on in!</p>
				</form>
			</div><!-- end free-class-container -->
			<div class="free-class-container-bottom"></div>
		</div><!-- end content -->

	</body>

</html>
