{extends file="layouts/core.tpl"}

{block name="head"}
	<title>Martial Arts Gyms in {$locality}, {$region}</title>
	{include file='includes/head/main-head.tpl'}
	<link rel="stylesheet" type="text/css" href="{$HOME}public/css/search.css"/>
	<link rel="stylesheet" href="{HOME}public/css/questionnaire.css">
	<link rel="canonical" href="https://www.jiujitsuscout.com/martial-arts-gyms/near-me/{$region_uri}/{$locality_uri}/">
	<meta name="description" content="Choose from the best martial arts gyms in {$locality|capitalize}, {$region|capitalize}. Sign up - Try for free - No obligation">
	<script src="{$HOME}{$JS_SCRIPTS}QuestionnaireDispatcher.js"></script>
	<script src="{$HOME}{$JS_SCRIPTS}search.js"></script>
	<script type="application/ld+json">
	[
	{foreach from=$businesses item=business name=business_loop}
		{literal}
		{
			"@context": "http://schema.org",
			"@type": "LocalBusiness",
			"name": "{/literal}{$business->business_name}{literal}",
			"description": "{/literal}{$business->message}{literal}",
			"image": "https://www.jiujitsuscout.com/public/img/uploads/{/literal}{$business->logo_filename}{literal}",
			"address": {
				"@type": "PostalAddress",
				"addressLocality": "{/literal}{$business->city}{literal}",
				"addressRegion": "{/literal}{$business->region}{literal}",
				"streetAddress": "{/literal}{$business->address_1}{literal}"
			},
			"geo": {
				"@type": "GeoCoordinates",
				"latitude": "{/literal}{$business->latitude|default:null}{literal}",
				"longitude": "{/literal}{$business->longitude|default:null}{literal}"
			}{/literal}{if $business->total_reviews > 0}{literal},
			"aggregateRating": {
				"@type": "AggregateRating",
				"ratingValue": "{/literal}{$business->rating}{literal}",
				"reviewCount": "{/literal}{$business->total_reviews}{literal}"
			},
			"reviews": [
				{/literal}
					{if $business->reviews|@count > 0}
						{foreach from=$business->reviews item=review name=review_schema}
						{
							"@type": "Review",
							"datePublished": "{$review->datetime|date_format:"%A, %b %e %Y %l:%M%p"}",
							"reviewBody": "{$review->review_body}",
							"reviewRating": {
								"ratingValue": {$review->rating}
							},
							"author": {
								"@type": "Person",
								"name": "{$review->name}"
							}
						}{if !$smarty.foreach.review_schema.last},{/if}
						{/foreach}
					{/if}
				{literal}
			]
			{/literal}{/if}{literal}
		}
		{/literal}
		{if !$smarty.foreach.business_loop.last},{/if}
	{/foreach}
	]
	</script>
{/block}
{block name="body"}
	{include file='includes/navigation/main-menu.tpl'}
	<div id="results" class="results-container bg-white floatleft">
		{if $businesses|@count < 1}
		<h2>No martial arts gyms in this area</h2>
		{/if}
		{foreach from=$businesses item=business name="business_listings"}
			{include file="includes/snippets/listing.tpl"}
			<div class="clear"></div>
			<!-- end school tag -->
		{/foreach}
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
	{include file='includes/footer.tpl'}
{/block}
