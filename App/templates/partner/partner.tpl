<!DOCTYPE html>
<html>
	<head>
    <title>Marketing your BJJ school | Jiu Jitsu Lead Generation</title>
		{include file='includes/head/main-head.tpl'}
		<link rel="stylesheet" type="text/css" href="{$HOME}css/partner.css"/>
	</head>
	<body>
		{include file='includes/navigation/main-menu.tpl'}
		<div class="clear"></div>
		<div class="content-lr-pad-none">
			<h1 class="h1 title-wrapper push-t-lrg push-b-lrg">Capture more leads{if isset($geoInfo->city)} in <span class="city-name" id="city-name">{$geoInfo->city}</span>{else}.{/if}</h1>
			<p class="sub-title h3">Create an account on our search engine to fill your gym with excited new students.</p>
			<div class="con-cnt-xlrg partner-box encapsulate first">
				<form method="post" action="{$HOME}partner/sign-up">
					<div class="con-inline">
						<div class="clear"></div>
						<input type="text" name="gym_name" class="sign-up-field" placeholder="Name of your gym">
					</div>
					<div class="con-inline">
						<input type="submit" class="sign-up-button mat-hov" value="Get Started"/>
					</div>
					<p class="partner-title-bottom">Capture some of the millions searching for martial arts near them</p>
				</form>
			</div>
			<div class="clear"></div>
			<div class="col-100 sign-up-free-box">
				<p class="h2 dark">It’s free to start!</p>
				<div class="clear push-t-med text-med"></div>
				<p class="h2">As soon as you set up your account, your business will show up in our search engine results and you can start engaging with new customers<p>
			</div>
			<div class="con-cnt-xlrg partner-overview encapsulate">
				<h2 class="title-wrapper h2">HOW IT WORKS</h2>
				<div class="col col-2">Image 1</div>
				<div class="col col-2-last overview-right">
					<h2>Visitor search for martial arts in their area</h2>
					<h3 class="list-item">Visitors use the search function to find martial arts gyms near them</h3>
				</div>
				<div class="clear"></div>
				<div class="col col-2">Image 2</div>
				<div class="col col-2-last">
					<h3 class="list-item">They select your listing and visit your lead capture profile...</h3>
				</div>
				<div class="clear"></div>
				<div class="col col-2">Image 3</div>
				<div class="col col-2-last">
					<h3 class="list-item">then sign up for your classes and we notify you immediately.</h3>
				</div>
				<div class="clear"></div>
				<div class="col col-2">Image 4</div>
				<div class="col col-2-last">
					<h3 class="list-item">We help you follow up with them using JiuJitsuScout tools such as automated follow-up email sequences, appointment-setting and reminder functionality, and sales-support systems.</h3>
				</div>
				<div class="clear"></div>
				<div class="col col-2">Image 5</div>
				<div class="col col-2-last">
					<h3 class="list-item">You give them a 5-star martial arts experience leave the rest to us!</h3>
				</div>
				<div class="clear"></div>
			</div>
			<div class="con-cnt-xlrg partner-tools">
				<h2 class="title-wrapper">Tools for partners to use</h2>
			</div>
		</div><!-- end content-->
		{include file='includes/footer.tpl'}
	</body>
</html>
