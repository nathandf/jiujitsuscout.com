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
{/block}
