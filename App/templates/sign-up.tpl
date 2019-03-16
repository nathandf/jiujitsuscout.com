{extends file="layouts/core.tpl"}

{block name="head"}
	<title>Free Martial Arts Classes Near You | Sign Up</title>
	<meta name="description" content="Sign up on connect with gyms near you that are offering free classes. Choose the gym you like best and try it for free.">
	<link rel="stylesheet" type="text/css" href="{$HOME}public/css/register.css"/>
{/block}

{block name="body"}
	{include file='includes/navigation/main-menu.tpl'}
	<div class="hero">
		<div class="overlay">
			<div class="inner-pad-med"></div>
			<div class="con-cnt-med-plus-plus inner-pad-med border-std bg-white">
				<h1 class="title title-h1 push-b-med" style="margin-top: 0;">Sign up for free classes</h1>
				<img class="img-sml" style="margin: 0 auto; display: block;" src="{$HOME}public/img/jjslogoiconwhite.jpg" alt="">
				<div class="clear push-t-med"></div>
				<a href="{$HOME}student-registration" class="btn btn-full push-t-lrg">Join as a Student</a>
				<div class="inner-pad-sml"></div>
				<div class="clear"></div>
				<p class="h3 push-t-med floatleft tc-deep-blue" style="font-weight: 600;">1. Pick the Disciplines and Programs that interest you</p>
				<div class="clear"></div>
				<p class="text-xlrg floatleft" style="margin-top: 5px; color: #777777;">Brazilian Jiu Jitsu, MMA, Kickboxing, Judo, Taekwondo, Karate, and much more!</p>
				<div class="clear"></div>
				<p class="h3 push-t-lrg floatleft tc-deep-blue" style="font-weight: 600;">2. Answer a few questions and register</p>
				<div class="clear"></div>
				<p class="text-xlrg push-t-sml floatleft" style="margin-top: 5px; color: #777777;">We'll show you the best gyms in your area based on your interests</p>
				<div class="clear"></div>
				<p class="h3 push-t-lrg floatleft tc-deep-blue" style="font-weight: 600;">3. Choose the best gyms and try a class for free</p>
				<div class="clear"></div>
				<p class="text-xlrg push-t-lrg floatleft" style="margin-top: 5px; color: #777777;">Contact the gyms and scedule a day that works best for you</p>
				<div class="clear"></div>
				<a href="{$HOME}student-registration" class="btn btn-full push-t-lrg">Join as a Student</a>
				<div class="inner-pad-sml"></div>
				<a href="{$HOME}partner/" class="tc-deep-blue push-t-med link">Join as a gym</a>
			</div>
			<div class="inner-pad-med"></div>
        </div>
	</div><!-- end content-->
{/block}
{block name="footer"}
	{include file='includes/footer.tpl'}
{/block}
