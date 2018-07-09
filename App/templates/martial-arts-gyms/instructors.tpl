{extends file="layouts/business-profile.tpl"}

{block name="business-profile-head"}
	{$facebook_pixel|default:""}
{/block}

{block name="business-profile-body"}
	<h2 class="page-title">Instructors</h2>
	<div class="instructors-container">
		<div class="instructors-header"><p>Meet our instructors!</p></div>
		<img class='instructor-image' src=''><p class='instructor-bio-header instructor-name'>No Instructors Added To Our Profile Yet</p>
		<br>
		<p class='instructor-bio'>If you're interested in learning more about our instructors, please visit our <a href='{$HOME}martial-arts-gyms/{$business->site_slug}/contact'>Contact Us</a> page and leave us a message! We will get back to you as soon as we recieve it!</p>
	</div><!-- end instructors-container -->
	{include file='includes/forms/sidebar-promo-form.tpl'}
	<div class="clear"></div>
	<div id="school-info-box">
		<p>Come by for your <a href="{$HOME}martial-arts-gyms/{$business->site_slug}/free-class">free trial class!</a></p>
		{include file='includes/widgets/js-google-map.tpl'}
		<div class="clear"></div>
		<p>{$business->address_1}{if $business->address_2} {$business->address_2}{/if}, {$business->city}, {$business->region} {$business->postal_code}</p>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
{/block}
