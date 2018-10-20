<!DOCTYPE html>
<html>
	<head>
	    <title>Find Martial Arts gyms near you | Try a class for free</title>
		<link rel="canonical" href="https://www.jiujitsuscout.com/">
	    <meta name="description" content="Find Martial Arts classes near you with our gym finder tool. Browse martial arts gyms in your area by discipline and try a class for free">
		<meta name="msvalidate.01" content="B9CB71BA77FCF02DC8BBE5FAA9A33456" />
		<script type="application/ld+json">
		{literal}
			[{
				"@context": "http://schema.org",
				"@type": "Organization",
				"name": "JiuJitsuScout",
				"legalName": "JiuJitsuScout LLC",
				"url": "https://www.jiujitsuscout.com",
				"logo": {
					"@type": "ImageObject",
					"name": "JiuJitsuScout logo",
					"text": "Find Martial Arts Near Me",
					"url": "https://www.jiujitsuscout.com/public/img/jjslogoiconwhite.jpg",
					"encodingFormat": "image/jpg"
				},
				"sameAs": [
					"https://twitter.com/Find_Bjj_Gyms",
					"https://www.facebook.com/JiuJitsuScout/",
					"https://www.facebook.com/jiujitsuscoutforbusiness/"
				],
				"contactPoint": {
					"@type": "ContactPoint",
					"contactType": "Customer Service",
					"telephone": "+1 (812) 276-3172",
					"email": "jiujitsuscout@gmail.com"
				}
			},
			{
				"@context": "http://schema.org",
				"@type": "Website",
				"name": "JiuJitsuScout",
				"headline": "Find martial arts near you and try classes for free",
				"url": "https://www.jiujitsuscout.com/",
				"potentialAction": {
					"@type": "SearchAction",
					"target": {
						"@type": "EntryPoint",
						"urlTemplate": "https://www.jiujitsuscout.com/search?q={query}"
					},
					"query-input": {
						"@type": "PropertyValueSpecification",
						"valueRequired": "True",
						"valueName": "query"
					}
				}
			}]
		{/literal}
		</script>

		<link rel="stylesheet" type="text/css" href="{$HOME}public/css/home.css"/>
	    {include file='includes/head/main-head.tpl'}
		{$facebook_pixel}
	    {include file='includes/tracking-codes/analyticstracking.html'}
	</head>
	<body>
	    {include file='includes/navigation/main-menu.tpl'}
		<div class="alt-content" >
			<div id="search-box">
				<div class="overlay-white-light">
					<div class="sb-overlay">
						<div class="con-cnt-xxlrg">
							<div class="inner-pad-med">
			        			<h1 class="search-title">Find {if !is_null($discipline)}{$discipline->nice_name}{else}Martial Arts{/if} Gyms Near&nbsp;You</h1>
								<div class="clear"></div>
								<form method="get" action="{$HOME}search">
						  		<input type="search" id="search-bar" name="q" placeholder="City, State, Region" value="{$geo|default:null}" >
								{if !is_null($discipline)}
								<input type="hidden" name="discid" value="{$discipline->id}">
								{/if}
								<button type="submit" class="" id="find-gyms-button"/><span class="dt">Find Gyms</span><span class="mo"><i class="fa fa-search" aria-hidden="true"></i></span></button>
						    	</form>
							</div>
		        		</div>
					</div>
				</div>
			</div><!-- end search-box -->
			<div class="col-100" style="border-top: 1px solid #CCC;"></div>
				<div class="con-cnt-xxlrg inner-pad-med">
					<h2 style="color: #2F3033;" class="push-b-lrg">Search by martial arts discipline</h2>
					{foreach from=$disciplines item=discipline name=discipline_loop}
					{if $smarty.foreach.discipline_loop.iteration < 9}
						<div class="discipline-container cursor-pt" style="box-sizing: border-box; padding: 5px; width: 25%; min-width: 150px; float: left;">
							<a href="{$HOME}disciplines/{$discipline->url}/near-me/" class="text-lrg-heavy link" style="color: #2F3033;">> {$discipline->nice_name}</a>
							<div class="clear push-b-sml"></div>
						</div>
						{if $smarty.foreach.discipline_loop.iteration % 4 == 0}
						<div class="clear"></div>
						{/if}
					{elseif $smarty.foreach.discipline_loop.iteration == 9}
						<div class="discipline-container cursor-pt" style="box-sizing: border-box; padding: 5px; width: 25%; min-width: 150px; float: left;">
							<a href="{$HOME}disciplines/" class="text-lrg link tc-deep-blue">— all disciplines</a>
							<div class="clear push-b-sml"></div>
						</div>
					{/if}
					{/foreach}
					<div class="clear"></div>
				</div>
			<div class="col-100" style="border-top: 1px solid #CCC;"></div>
			<div class="con-cnt-xxlrg inner-pad-med">
				<h2 style="color: #2F3033;" class="push-b-lrg">Find martial arts gyms by region</h2>
				{foreach from=$businesses_geo_info item=businesses_geo_info_by_region name=by_region_loop key=key}
					<div class="region-block" style="box-sizing: border-box; padding: 5px; width: 25%; min-width: 150px; float: left;">
						{foreach from=$businesses_geo_info_by_region item=business_geo_info name=business_geo_info_loop}
							{if $smarty.foreach.business_geo_info_loop.iteration < 5}
								{if $smarty.foreach.business_geo_info_loop.iteration == 1}
								<a href="{$HOME}martial-arts-gyms/near-me/{$business_geo_info[ 'region_url' ]}/" class="text-lrg-heavy link" style="color: #2F3033;">{$key|capitalize}</a>
								<div class="clear push-b-sml"></div>
								{/if}
							<a class="link text-med" style="color: #777;" href="{$HOME}martial-arts-gyms/near-me/{$business_geo_info[ 'region_url' ]}/{$business_geo_info[ 'locality_url' ]}/">{$business_geo_info[ "locality" ]}</a>
							<div class="clear"></div>
							{elseif $smarty.foreach.business_geo_info_loop.iteration == 5}
							<a class="link text-med tc-deep-blue" href="{$HOME}martial-arts-gyms/near-me/{$business_geo_info[ 'region_url' ]}/">— more</a>
							<div class="clear push-t-sml"></div>
							{/if}
						{/foreach}
					</div>
					{if $smarty.foreach.by_region_loop.iteration % 4 == 0}
					<div class="clear"></div>
					{/if}
				{/foreach}
				<div class="clear push-t-med"></div>
			</div>
		</div><!-- end content-->
    {include file='includes/footer.tpl'}
	</body>
</html>
