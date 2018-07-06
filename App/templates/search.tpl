<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
    <title>Find Brazilian Jiu Jitsu classes and MMA near me | BJJ Schools, MMA Gyms and more</title>
    <meta name="description" content="Find Brazilian Jiu Jitsu classes and MMA gyms near you with our BJJ Gym Finder. Browse martial arts gyms in your area and try a class for free">
		<meta name="msvalidate.01" content="B9CB71BA77FCF02DC8BBE5FAA9A33456" />
		<span itemscope itemtype="http://schema.org/Organization" itemid="#amt-organization">
		<meta itemprop="name" content="Jiu Jitsu Classes and MMA gyms Near Me | BJJ School Finder" />
		<span itemprop="logo" itemscope itemtype="http://schema.org/ImageObject">
			<meta itemprop="name" content="Brazilian Jiu Jitsu Classes and MMA Gyms Near Me logo" />
			<meta itemprop="text" content="Find Jiu Jitsu near me logo" />
			<meta itemprop="url" content="http://www.jiujitsuscout.com/img/jiujitsuscoutlogo.jpg" />
			<meta itemprop="contentUrl" content="http://www.jiujitsuscout.com/img/jiujitsuscoutlogo.jpg" />
			<meta itemprop="encodingFormat" content="image/jpg" />
		</span>
		<meta itemprop="url" content="http://www.jiujitsuscout.com/" />
		<meta itemprop="sameAs" content="https://twitter.com/Find_Bjj_Gyms" />
		<meta itemprop="sameAs" content="https://www.facebook.com/JiuJitsuScout/" />
		<meta itemprop="mainEntityOfPage" content="http://www.jiujitsuscout.com/" />
		</span>
		<span itemscope itemtype="http://schema.org/WebSite" itemid="#amt-website">
		<meta itemprop="name" content="BJJ School FInder | BJJ near me" />
		<meta itemprop="headline" content="Home" />
		<meta itemprop="url" content="http://www.jiujitsuscout.com/" />
		<link rel="canonical" href="http://www.jiujitsuscout.com/">
		{include file="includes/head/main-head.tpl"}
		<link rel="stylesheet" type="text/css" href="{$HOME}css/search.css"/>
		<script src="{$HOME}{$JS_SCRIPTS}search.js"></script>
	</head>
	<body>
		{include file="includes/navigation/main-menu.tpl"}
	    <div class="results-header">
	      <form method="get" onsubmit="" action="search#results" >

	      <span itemprop="potentialAction" itemscope itemtype="http://schema.org/SearchAction">
	        <span itemprop="target" itemscope itemtype="http://schema.org/EntryPoint">
	          <meta itemprop="urlTemplate" content="http://www.jiujitsuscout.com/?search={literal}{search_term}{/literal}" />
	        </span>
	        <span itemprop="query-input" itemscope itemtype="http://schema.org/PropertyValueSpecification">
	          <meta itemprop="valueRequired" content="True" />
	          <meta itemprop="valueName" content="search_term" />
	        </span>
	      </span>
	        <input type="search" class="search_bar encapsulate" id="search_bar" name="q" placeholder="City, State or Zip" require="required"/>
	        <input type="submit" class="mat-hov search_button" id="search_button" value="Find Gyms" /><br>
	      </form>
	    	<p><strong>Showing ({$total_results}) results for "{$query}"</strong></p>
	    </div>
		{if $total_results > 0 }
		<div id="results" class="results-container">
			{foreach from=$results item=business name="business_listings"}
				<div class="business-tag mat-hov">
					<img class="business-logo encapsulate" src="{$HOME}img/uploads/{$business->logo_filename}" />
					<div class="info_1">
						<a class="name" href="{$HOME}martial-arts-gyms/{$business->site_slug}/">{$business->business_name}</a>
						<p>{$business->stars}</p>
						<p>{if $business->rating == 0}Not rated{else}{$business->rating}/5{/if}</p>
						<p class="text-sml">Distance: {$business->distance|round:2}{$business->unit}</p>
					</div>
					<span class="info_2">
						<p class="text-med-heavy">Offer</p>
						<p class="text-med">{$business->promotional_offer}</p>
						<div class="clear"></div>
						<button id="request-offer-{$smarty.foreach.business_listings.iteration}" class="mat-hov-alt request-offer-btn bg-good-green push-t cursor-pt --offer-request-form-drop"><span class="tc-white text-sml-heavy">Get Offer</span></button>
						<button id="request-schedule-{$smarty.foreach.business_listings.iteration}" class="mat-hov-alt request-schedule-btn bg-mango push-t cursor-pt --schedule-request-form-drop"><span class="tc-good-green text-sml-heavy">Request Schedule</span></button>
						<div class="clear"></div>
					</span>
					<div class="clear"></div>
					<div class="review">
						<i class="fa fa-user-circle-o fa-2x user_icon" aria-hidden="true"></i>
						<span>
							<span class="review_name"><b>{if isset($business->reviewer)}{$business->reviewer|truncate:20}{else}<a class="link" href="{$HOME}martial-arts-gyms/{$business->site_slug}/#review">Be the first to review</a>{/if}</b></span><span class="review_text">{$business->review|default:null|truncate:75:"..."}
							{if isset($business->review)}<a class="text-sml link" href="{$HOME}martial-arts-gyms/{$business->site_slug}/reviews">Read more</a>{/if}
							</span>
						</span>
					</div>
					<div id="offer-request-form-{$smarty.foreach.business_listings.iteration}" style="display: none;" class="business-tag-form">
						<p class="text-med-heavy push-b">Get Offer - {$business->promotional_offer}</h2>
						<form method="post" action="{$HOME}request">
							<input type="hidden" name="token" value="{$csrf_token}">
							<input type="hidden" name="request" value="offer">
							<input type="hidden" name="q" value="{$query}">
							<input type="hidden" name="discid" value="{$discid}">
							<input type="hidden" name="business_id" value="{$business->id}">
							<input type="text" name="name" placeholder="Name" class="inp business-tag-form-input">
							<input type="text" name="email" placeholder="Email" class="inp business-tag-form-input">
							<input type="text" name="number" placeholder="Phone Number" class="inp business-tag-form-input">
							<input type="submit" class="btn btn-inline floatright" value="Send Request">
						</form>
					</div>
					<div id="schedule-request-form-{$smarty.foreach.business_listings.iteration}" style="display: none;" class="business-tag-form">
						<p class="text-med-heavy push-b">Request Schedule</p>
						<form method="post" action="{$HOME}request">
							<input type="hidden" name="token" value="{$csrf_token}">
							<input type="hidden" name="request" value="schedule">
							<input type="hidden" name="q" value="{$query}">
							<input type="hidden" name="discid" value="{$discid}">
							<input type="hidden" name="business_id" value="{$business->id}">
							<input type="text" name="name" placeholder="Name" class="inp business-tag-form-input">
							<input type="text" name="email" placeholder="Email" class="inp business-tag-form-input">
							<input type="text" name="number" placeholder="Phone Number" class="inp business-tag-form-input">
							<input type="submit" class="btn btn-inline floatright" value="Send Request">
						</form>
					</div>
				</div>
				<div class="clear"></div>

				<!-- end school tag -->
			{/foreach}
		<div class="clear"></div>
	    </div>
		{else}
		<div class="con-cnt-xlrg last">
			<p>No results found within a {$search_radius}{$unit} distance.</p>
		</div>
		{/if}
	    <div class="results_side_bar">
	    </div>
	    <div class="clear"></div>
	    {include file="includes/footer.tpl"}
	</body>
</html>
