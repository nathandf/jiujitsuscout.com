<div class="listing">
	<div class="floatleft">
		<img class="business-logo push-r-med" src="{$HOME}public/img/uploads/{$business->logo_filename}" />
		<a class="name --clickable" href="{$HOME}martial-arts-gyms/{$business->site_slug}/" data-property="listing" data-b_id="{$business->id}" data-ip="{$ip}">{$business->business_name}</a>
		<p>{$business->stars} <span class="text-sml">{if $business->rating == 0}Not rated{else}{$business->rating}/5{/if}</span></p>
		<p class="text-sml">Distance: {$business->distance|round:2}{$business->unit}</p>
		<div class="clear"></div>
	</div>
	<div class="view-profile-button-container">
		<a class="btn view-profile-button bg-deep-blue text-med-heavy tc-white --clickable" href="{$HOME}martial-arts-gyms/{$business->site_slug}/">View Profile</a>
	</div>
	<div class="clear"></div>
</div>
