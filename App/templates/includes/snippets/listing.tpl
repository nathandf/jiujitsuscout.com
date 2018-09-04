<div class="listing">
	<div class="floatleft">
		<img class="business-logo push-r-med" src="{$HOME}public/img/uploads/{$business->logo_filename}" />
		<a class="name --clickable" href="{$HOME}martial-arts-gyms/{$business->site_slug}/" data-property="listing" data-b_id="{$business->id}" data-ip="{$ip}">{$business->business_name}</a>
		<p>{$business->stars} <span class="text-sml">{if $business->reviews|@count < 1}Not rated{else}({$business->reviews|@count}){/if}</span></p>
		<p class="text-sml">Distance: {$business->distance|round:2}{$business->unit}</p>
		<div class="discipline-tags-container">
			{foreach from=$business->disciplines item=discipline name="business_discipline_loop"}
				{if $smarty.foreach.business_discipline_loop.iteration < 6}
				<span class="--clickable --q-trigger tc-gun-metal push-t text-sml cursor-pt discipline-tag" data-property="listing" data-property_sub_type="discipline-tag-{$discipline->id}" data-b_id="{$business->id}" data-ip="{$ip}">{$discipline->nice_name}</span>
				{elseif $smarty.foreach.business_discipline_loop.iteration == 6}
				<a href="{$HOME}martial-arts-gyms/{$business->site_slug}/" class="--clickable link tc-gun-metal push-t text-sml"  data-property="listing" data-property_sub_type="discipline-and-more-link" data-b_id="{$business->id}" data-ip="{$ip}">— more</a>
				{/if}
			{/foreach}
		</div>
		<div class="clear"></div>
	</div>
	<div class="view-profile-button-container">
		<a class="btn view-profile-button bg-deep-blue text-med-heavy tc-white --clickable" href="{$HOME}martial-arts-gyms/{$business->site_slug}/" data-property="listing" data-b_id="{$business->id}" data-ip="{$ip}">View Profile</a>
	</div>
	<div class="clear"></div>
</div>
