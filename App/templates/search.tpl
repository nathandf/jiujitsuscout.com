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
			<span itemprop="potentialAction" itemscope itemtype="http://schema.org/SearchAction">
				<span itemprop="target" itemscope itemtype="http://schema.org/EntryPoint">
					<meta itemprop="urlTemplate" content="https://www.jiujitsuscout.com/?search={literal}{search_term}{/literal}" />
				</span>
				<span itemprop="query-input" itemscope itemtype="http://schema.org/PropertyValueSpecification">
					<meta itemprop="valueRequired" content="True" />
					<meta itemprop="valueName" content="search_term" />
				</span>
			</span>
			<input type="search" class="search_bar encapsulate" id="search_bar" name="q" placeholder="City, State or Zip" require="required"/>
			<input type="submit" class="mat-hov find-gym-button bg-deep-blue" id="search_button" value="Find Gyms" /><br>
	      </form>
		  <a class="--clickable choose-gym-button cursor-pt --q-trigger tc-deep-blue text-sml" data-property="search-results" data-property_sub_type="help-choose-a-gym-button" data-b_id="0" data-ip="{$ip}">Help Me Choose a Gym</a>
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
				<p class="push-b-med inner-pad-med">No results found within a {$search_radius} {$unit} distance.</p>
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
