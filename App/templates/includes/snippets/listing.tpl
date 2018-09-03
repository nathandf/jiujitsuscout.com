<div class="listing">
	<div class="floatleft">
		<img class="business-logo push-r-med" src="{$HOME}public/img/uploads/{$business->logo_filename}" />
		<a class="name --clickable" href="{$HOME}martial-arts-gyms/{$business->site_slug}/" data-property="listing" data-b_id="{$business->id}" data-ip="{$ip}">{$business->business_name}</a>
		<p>{$business->stars} <span class="text-sml">{if $business->reviews|@count < 1}Not rated{else}({$business->reviews|@count}){/if}</span></p>
		<p class="text-sml">Distance: {$business->distance|round:2}{$business->unit}</p>
		{foreach from=$business->disciplines item=discipline name="business_discipline_loop"}
			<span class="--clickable --q-trigger tc-gun-metal push-t-sml text-sml cursor-pt" style="border-radius: 2px; border: 1px solid #CCC; padding: 1px; box-sizing: border-box;" data-property="listing" data-b_id="{$business->id}" data-ip="{$ip}">{$discipline->nice_name}</span>
		{/foreach}
		<div class="clear"></div>
	</div>
	<div class="view-profile-button-container">
		<a class="btn view-profile-button bg-deep-blue text-med-heavy tc-white --clickable" href="{$HOME}martial-arts-gyms/{$business->site_slug}/" data-property="listing" data-b_id="{$business->id}" data-ip="{$ip}">View Profile</a>
	</div>
	<div class="clear"></div>
</div>
