<!DOCTYPE html>
<html>
	<head>
	    <title>Marketing Your Martial Arts Business | Generate Leads</title>
		{include file='includes/head/main-head.tpl'}
		<link rel="stylesheet" type="text/css" href="{$HOME}public/css/partner.css"/>
	</head>
	<body>
		{include file='includes/navigation/main-menu.tpl'}
		<div class="clear"></div>
		<div>
			<h1 class="h1 title-wrapper push-t-lrg push-b-lrg">Capture more leads{if isset($geoInfo->city)} in <span class="city-name" id="city-name">{$geoInfo->city}</span>{else}.{/if}</h1>
			<p class="sub-title h3">Create an account on our search engine and fill your gym with excited new students.</p>
			<div class="con-cnt-xlrg partner-box encapsulate first">
				<form method="post" action="{$HOME}partner/sign-up">
					<div class="con-inline">
						<div class="clear"></div>
						<input type="text" name="gym_name" class="sign-up-field" placeholder="Name of your gym">
					</div>
					<div class="con-inline">
						<input type="submit" class="sign-up-button mat-hov" value="Get Started"/>
					</div>
					<p class="partner-title-bottom">Millions of people are searching for martial arts around the world everyday.<br>We'll help them find you.</p>
				</form>
			</div>
			<div class="clear"></div>
			<div class="col-100 sign-up-free-box push-b-lrg">
				<p class="h2 dark">It’s free to start!</p>
				<div class="clear push-t-med text-med"></div>
				<p class="h2">As soon as you set up your account, your business will show up in our search engine results and you can start engaging with new customers<p>
			</div>
		</div><!-- end content-->
		{include file='includes/footer.tpl'}
	</body>
</html>
