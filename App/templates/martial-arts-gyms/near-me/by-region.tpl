{extends file="layouts/core.tpl"}

{block name="head"}
	<title>Find Martial Arts Gyms in {$region|capitalize} | Choose A City</title>
	<meta name="description" content="Choose the city in which you're interested in try martial arts classes and then choose the gym that you like the best.">
	<link rel="stylesheet" type="text/css" href="{$HOME}public/css/home.css"/>
	{include file='includes/head/main-head.tpl'}
	{$facebook_pixel}
{/block}

{block name="body"}
{include file='includes/navigation/main-menu.tpl'}
	<div class="alt-content" >
		<div class="con-cnt-xxlrg inner-pad-med">
			<h1 style="color: #2F3033;" class="h2 push-b-lrg">Find martial arts in {$region|capitalize} by city</h1>
			{foreach from=$businesses_geo_info item=business_geo_info name=business_geo_info_loop}
				<a class="link text-lrg" style="color: #777;" href="{$HOME}martial-arts-gyms/near-me/{$business_geo_info[ 'region_uri' ]}/{$business_geo_info[ 'locality_uri' ]}/">{$business_geo_info[ "locality" ]}</a>
				<div class="clear push-t-sml"></div>
			{/foreach}
		</div>
		<div class="clear"></div>
	</div>
{/block}

{block name="footer"}
	{include file='includes/footer.tpl'}
{/block}
