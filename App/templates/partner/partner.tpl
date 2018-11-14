<!DOCTYPE html>
<html>
	<head>
	    <title>Marketing Your Martial Arts Business | Generate Leads</title>
		<meta name="description" content="Generate new members for your martial arts gym. Lead generation services where you can pay per lead, or run monthly lead generation campaigns.">
		{include file='includes/head/main-head.tpl'}
		<link rel="stylesheet" type="text/css" href="{$HOME}public/css/partner.css"/>
		<script src="{$HOME}{$JS_SCRIPTS}partner.js"></script>
		{$facebook_pixel|default:null}
	</head>
	<body>
		{include file='includes/navigation/main-menu.tpl'}
		{include file="includes/modals/marketing-consultation.tpl"}
		<div id="get-started" class="clear"></div>
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
						<input type="submit" class="sign-up-button mat-hov bg-deep-blue" value="Get Started"/>
					</div>
					<p class="partner-title-bottom">Millions of people are searching for martial arts around the world everyday.<br>We'll help them find you.</p>
				</form>
			</div>
			<div class="clear"></div>
			<div id="how-it-works" class="col-100 bg-white push-t-lrg inner-pad-med" style="border-top: 1px solid #CCCCCC;">
				<div class="con-cnt-xxlrg inner-pad-med" style="text-align: left;">
					<p class="text-lrg push-t-med" style="color: #333;">HOW IT WORKS</p>
					<div class="style-line"></div>
					<h2 class="headline push-b-med">Lead generation. The easy way.</h2>
					<p class="h3 push-t-med floatleft tc-deep-blue" style="font-weight: 600;">1. Create an account for your martial arts business</p>
					<div class="clear"></div>
					<p class="text-xlrg floatleft" style="margin-top: 5px; color: #777777;">Visitors search for martial arts gyms in their area. Create your free profile so they can find you on our platform</p>
					<div class="clear"></div>
					<p class="h3 push-t-lrg floatleft tc-deep-blue" style="font-weight: 600;">2. Visitors looking for classes explore your profile</p>
					<div class="clear"></div>
					<p class="text-xlrg push-t-sml floatleft" style="margin-top: 5px; color: #777777;">Encourage users to engage with your profile by filling it with useful information. Add Frequently asked question, programs, special offers, images and much more.</p>
					<div class="clear"></div>
					<p class="h3 push-t-lrg floatleft tc-deep-blue" style="font-weight: 600;">3. We qualify you profile visitors by determining their needs, wants, and level of interest</p>
					<div class="clear"></div>
					<p class="text-xlrg push-t-lrg floatleft" style="margin-top: 5px; color: #777777;">Not all leads are created equal. A prospect's value is determined by the actions they take on our platform. The hotter the lead, the more valuable they are.</p>
					<div class="clear"></div>
					<p class="h3 push-t-lrg floatleft tc-deep-blue" style="font-weight: 600;">4. Receive real-time notifications when you get a new lead</p>
					<div class="clear"></div>
					<p class="text-xlrg push-t-lrg floatleft" style="margin-top: 5px; color: #777777;">The goal of marketing is get leads and turn the into paying customers. We make that quick and easy for you to follow up with them with our built-in lead management system.</p>
					<div class="clear"></div>
					<div class="clear"></div>
					<p class="h3 push-t-lrg floatleft tc-deep-blue" style="font-weight: 600;">5. Review the lead and make an informed decision before you purchase it</p>
					<div class="clear"></div>
					<p class="text-xlrg push-t-lrg floatleft" style="margin-top: 5px; color: #777777;">Once you're satisfied with your leads, complete your purchase by adding account credit and get them scheduled to try a class.</p>
					<div class="clear"></div>
					<a href="#get-started" class="btn button-med floatleft bg-deep-blue push-t-lrg">Get Started</a>
					<div class="clear"></div>
				</div>
			</div>
			<div class="clear"></div>
			<div class="col-100 inner-pad-med bg-white" style="border-top: 1px solid #CCCCCC;">
				<div class="con-cnt-xxlrg inner-pad-med" style="text-align: left;">
					<p class="text-lrg push-t-med" style="color: #333;">FEATURES</p>
					<div class="style-line"></div>
					<h2 class="headline">We're more than a Lead Generation Platform</h2>
					<p class="text-xlrg push-t-lrg floatleft" style="margin-top: 5px; color: #777777;">Here's a few ways JiuJitsuScout can help your martial arts business generate more revenue</p>
					<div class="clear"></div>
					<p class="h3 push-t-lrg tc-deep-blue" style="font-weight: 600;">Manage your leads with a fully functional CRM</p>
					<p class="text-xlrg" style="margin-top: 5px; color: #777777;">• Import prospects from other sources</p>
					<p class="text-xlrg" style="margin-top: 5px; color: #777777;">• Set appointments</p>
					<p class="text-xlrg" style="margin-top: 5px; color: #777777;">• Recieve automated appointment reminders for both the lead and appointment setter</p>
					<p class="text-xlrg" style="margin-top: 5px; color: #777777;">• Track and manage trial memberships</p>
					<p class="text-xlrg" style="margin-top: 5px; color: #777777;">• Create, delegate, and follow up with tasks</p>
					<p class="h3 push-t-lrg tc-deep-blue" style="font-weight: 600;">Marketing Management Sytem</p>
					<p class="text-xlrg" style="margin-top: 5px; color: #777777;">• Create lead capture pages perfect for social media campaigns</p>
					<p class="text-xlrg" style="margin-top: 5px; color: #777777;">• Retarget your profile visiors with your Facebook Pixel</p>
					<p class="text-xlrg" style="margin-top: 5px; color: #777777;">• Order Social Media and Search Engine Marketing Campigns</p>
					<div class="clear"></div>
					<a href="{$HOME}partner/sign-up" class="btn button-med floatleft bg-deep-blue push-t-lrg">Sign up</a>
					<div class="clear"></div>
				</div>
			</div>
			<div class="clear"></div>
			<div class="col-100 inner-pad-med bg-deep-blue" style="border-top: 1px solid #CCCCCC;">
				<div class="con-cnt-xxlrg inner-pad-med" style="text-align: left;">
					<h2 class="headline" style="color: #FFF;">Need to generate even more leads?</h2>
					<p class="h2 push-t-med floatleft tc-white">Let our marketing experts fill your gym with excited new students with our Social Media and Search Engine marketing servces.</p>
					<div class="clear"></div>
					<button type="button" id="marketing-consultation-button" class="btn button-med-round floatleft bg-gold tc-black push-t-lrg">Request Free Consultation</button>
					<div class="clear"></div>
				</div>
			</div>
			<div class="clear"></div>
			<div class="col-100 bg-white inner-pad-med" style="border-top: 1px solid #CCCCCC;">
				<div class="con-cnt-xxlrg inner-pad-med" style="text-align: left;">
					<p class="text-lrg push-t-med" style="color: #333;">RESOURCES</p>
					<div class="style-line"></div>
					<h2 class="headline">Keep your business running at peak performance</h2>
					<p class="h2 push-t-med floatleft">Follow our martial arts business blog to stay up-to-date with articles on marketing, sales, seo, staff development, and helpful tips for businesses in the martial arts industry.</p>
					<div class="clear"></div>
					<a href="{$HOME}martial-arts-business-blog/" class="btn button-med floatleft bg-deep-blue push-t-lrg">Visit Blog</a>
					<div class="clear"></div>
				</div>
			</div>
		</div><!-- end content-->
		{include file='includes/footer.tpl'}
	</body>
</html>
