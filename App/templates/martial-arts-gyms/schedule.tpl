{extends file="layouts/business-profile.tpl"}

{block name="business-profile-head"}
	{$facebook_pixel|default:""}
{/block}

{block name="business-profile-body"}
	<h2 class="page-title">Schedule</h2>
	<div class="schedule-container">
	</div><!-- end schedule-container -->
	{include file='includes/forms/sidebar-promo-form.tpl'}
	<div class="clear"></div>
	<div id="school-info-box">
		<p>Come by for your <a href="{$HOME}martial-arts-gyms/{$business->site_slug}/free-class">free trial class!</a></p>
		{include file='includes/snippets/js-google-map.tpl'}
		<div class="clear"></div>
		<p>{$business->address_1}, {$business->city}, {$business->region} {$business->postal_code}</p>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
{/block}
