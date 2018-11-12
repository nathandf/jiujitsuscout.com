<!DOCTYPE html>
<html>
	<head>
	    <title>Marketing Your Martial Arts Business | Generate Leads</title>
		<meta name="description" content="Generate new members for your martial arts gym. Lead generation services where you can pay per lead, or run monthly lead generation campaigns.">
		{include file='includes/head/main-head.tpl'}
		<link rel="stylesheet" type="text/css" href="{$HOME}public/css/partner.css"/>
		{$facebook_pixel|default:null}
	</head>
	<body>
		{include file='includes/navigation/main-menu.tpl'}
		<div class="clear"></div>
		<div>
			<p class="push-t-lrg push-b-lrg headline" style="text-align: center;">Capture more leads{if isset($geoInfo->city)} in <span class="city-name" id="city-name">{$geoInfo->city}</span>{else}.{/if}</p>
			<div class="con-cnt-lrg inner-pad-med">
				<p class="sub-title text-xlrg">Create a free account on our lead generation platform and fill your gym with excited new students. Only pay for the leads your want!</p>
			</div>
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
			<div class="col-100 sign-up-free-box inner-pad-med push-b-lrg">
				<div class="con-cnt-lrg inner-pad-med" style="text-align: left;">
					<p class="h2 dark">How It Works</p>
					<p class="h2 push-t-lrg floatleft"> 1) Visitors search for martial arts gyms in their area</p>
					<p class="h2 push-t-med floatleft"> 2) We qualify their level of interest...</p>
					<p class="h2 push-t-med floatleft"> 3) And let you know when they become a lead</p>
					<p class="h2 push-t-med floatleft"> 4) You evaluate the lead to see if it meets your standards</p>
					<p class="h2 push-t-med floatleft"> 5) Purchase it and schedule them to come in for a free class!</p>
					<div class="clear"></div>
					<a href="{$HOME}partner/sign-up" class="btn btn-med floatleft bg-deep-blue push-t-lrg">Get Started</a>
					<div class="clear"></div>
				</div>
			</div>
			<div class="clear"></div>
			<div class="col-100 sign-up-free-box inner-pad-med push-b-lrg">
				<div class="con-cnt-lrg inner-pad-med" style="text-align: left;">
					<p class="h2 dark">JiuJitsuScout is more than a search engine</p>
					<p class="h2 push-t-med floatleft">It's a lead geneation and marketing automation platform for martial arts business.</p>
					<p class="h2 push-t-med floatleft">You can manage your prospects, set appointments, send reminders, track trial memeberships, and much more with our full functional CRM (Customer Relationship Manager)</p>
					<div class="clear"></div>
					<a href="{$HOME}partner/sign-up" class="btn btn-med floatleft bg-deep-blue push-t-lrg">Sign up</a>
					<div class="clear"></div>
				</div>
			</div>
			<div class="clear"></div>
			<div class="col-100 sign-up-free-box inner-pad-med push-b-lrg">
				<div class="con-cnt-lrg inner-pad-med" style="text-align: left;">
					<p class="h2 dark">Need to generate even more leads?</p>
					<p class="h2 push-t-med floatleft">That's what we do!</p>
					<p class="h2 push-t-med floatleft">Let our marketing experts fill your gym with excited new students with our Social Media and Search Engine marketing servces.</p>
					<div class="clear"></div>
					<a href="{$HOME}partner/sign-up" class="btn btn-med floatleft bg-deep-blue push-t-lrg">Learn More</a>
					<div class="clear"></div>
				</div>
			</div>
			<div class="clear"></div>
			<div class="col-100 sign-up-free-box inner-pad-med push-b-lrg">
				<div class="con-cnt-lrg inner-pad-med" style="text-align: left;">
					<p class="h2 dark">Keep your business running at peak performance</p>
					<p class="h2 push-t-med floatleft">Follow our martial arts business blog to stay up-to-date with articles on marketing, sales, seo, staff development, and helpful tips for businesses in the martial arts industry.</p>
					<div class="clear"></div>
					<a href="{$HOME}martial-arts-business-blog/" class="btn btn-med floatleft bg-deep-blue push-t-lrg">Visit Blog</a>
					<div class="clear"></div>
				</div>
			</div>
		</div><!-- end content-->
		{include file='includes/footer.tpl'}
	</body>
</html>
