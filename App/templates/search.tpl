<!DOCTYPE html>
<html>
	<head>
    	<title>Find Martial Arts near me | BJJ Schools, MMA Gyms and more</title>
		{include file="includes/head/main-head.tpl"}
		<link rel="stylesheet" type="text/css" href="{$HOME}public/css/search.css"/>
		<link rel="stylesheet" href="{HOME}public/css/questionnaire.css">
		{$facebook_pixel}
		<script src="{$HOME}{$JS_SCRIPTS}QuestionnaireDispatcher.js"></script>
		<script src="{$HOME}{$JS_SCRIPTS}search.js"></script>
	</head>
	<body>
		{include file="includes/widgets/questionnaire.tpl"}
		{include file="includes/navigation/main-menu.tpl"}
		<div class="clear"></div>
	    <div class="results-header">
	      <form method="get" onsubmit="" action="search#results" >
			<input type="search" class="search_bar encapsulate" id="search_bar" name="q" placeholder="City, State or Zip" require="required"/>
			<input type="submit" class="mat-hov find-gym-button bg-deep-blue" id="search_button" value="Find Gyms" /><br>
	      </form>
	    	<p class="push-t-med"><strong>Showing ({$total_results}) results for "{$query}"</strong></p>
	    </div>
		<div class="results-body">
		{if $total_results > 0 }
			<div class="results-side-bar bg-white floatleft">

			</div>
			<div id="results" class="results-container bg-white floatleft">
				{foreach from=$results item=business name="business_listings"}
					{include file="includes/snippets/listing.tpl"}
					<div class="clear"></div>
					<!-- end school tag -->
				{/foreach}
				<div class="clear"></div>
		    </div>
			{else}
			<div id="results" class="push-b-med" style="border-bottom: 1px solid #CCCCCC;">
				<div class="inner-pad-med">
					<p class="text-med">
						Don't see your gym?
						<a class="link tc-deep-blue" href="{$HOME}partner/">Add it now</a>
					</p>
				</div>
			</div>
			<div class="">
				<div class="inner-pad-med">
					<p class="no-entries"><span style="color: green; font-weight: 600; text-decoration: underline;">BUT DON'T WORRY!</span><br>
						Just enter your info below and we will get you in touch with a professional martial arts instructor in your area!
					</p>
				</div>
				<div class="con-cnt-fit encapsulation">
				<h2>Get in contact</h2>
					<form method="get" action="">
						<input type="hidden" name="no_results" value="{$csrf_token}">
						<input type="hidden" name="token" value="{$csrf_token}">
						<input type="text" class="inp field-med push-t" name="name" placeholder="Name" required="required">
						<input type="email" class="inp field-med push-t push-t" name="email" placeholder="Email" required="required">
						<input type="text" class="inp field-med push-t" name="number" placeholder="Phone Number" required="required">
						<input type="hidden" name="q" value="{$query}">
						<input type="submit" class="btn btn-inline push-t-med" value="Contact me">
					</form>
				</div>
				<div class="clear"></div>
			</div>
			{/if}
		    <div class="clear"></div>
		</div>
		<div class="clear"></div>
	    {include file="includes/footer.tpl"}
	</body>
</html>
