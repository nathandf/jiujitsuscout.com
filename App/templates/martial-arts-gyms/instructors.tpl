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
	<div class="inner-pad-med" style="border-top: 1px solid #CCCCCC;">
		<a class="btn btn-inline push-r-med floatright " href="{$HOME}martial-arts-gyms/{$business->site_slug}/free-class" style="margin-bottom: 0;">Free Class</a>
		<table cellspacing="0" class="">
			<tr>
				<td style="padding: 0px;"><p class="text-med-heavy">Phone: </p></td>
				<td style="padding: 0px;"><p class="text-sml push-l">+{$business->phone->country_code} {$business->phone->national_number}</p></td>
			</tr>
			<tr>
				<td style="padding: 0px;"><p class="text-med-heavy">Address: </p></td>
				<td style="padding: 0px;"><p class="text-sml push-l">{$business->address_1}, {$business->city}, {$business->region} {$business->postal_code}</p></td>
			</tr>
		</table>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
	{include file='includes/widgets/js-google-map.tpl'}
	<div class="clear"></div>
	<div class="clear"></div>
{/block}
