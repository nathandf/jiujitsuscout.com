<div class="listing">
		<div class="left-container business-logo-container push-r-med floatleft">
			<img class="business-logo" src="{if !is_null($business->logo_image_id)}{$HOME}public/img/uploads/{$business->logo->filename}{else}http://placehold.it/300x300&text=No+Image{/if}" />
		</div>
		<div class="middle-container">
			<a class="name --clickable" href="{$HOME}martial-arts-gyms/{$business->id}/" data-property="listing" data-property_sub_type="business-name" data-b_id="{$business->id}" data-ip="{$ip}">{$business->business_name|truncate:25:"..."}</a>
			<p>{$business->stars} <span class="text-sml">{if $business->reviews|@count < 1}Not rated{else}<span class="--clickable" data-property="listing" data-property_sub_type="reviews" data-b_id="{$business->id}" data-ip="{$ip}">(<a class="link tc-black" href="{$HOME}martial-arts-gyms/{$business->id}/">{$business->reviews|@count}</a>)</span>{/if}</span></p>
			{if isset($business->distance) && isset($business->unit)}
			<p class="text-sml">Distance: {$business->distance|round:2}{$business->unit}</p>
			{/if}
			<div class="discipline-tags-container">
				{foreach from=$business->disciplines item=discipline name="business_discipline_loop"}
					{if $smarty.foreach.business_discipline_loop.iteration < 4}
					<p class="--clickable --q-trigger tc-gun-metal push-t text-sml cursor-pt discipline-tag" style="display: inline-block;" data-property="listing" data-property_sub_type="discipline-tag-{$discipline->id}" data-b_id="{$business->id}" data-ip="{$ip}">{$discipline->nice_name}</p>
					{elseif $smarty.foreach.business_discipline_loop.iteration == 4}
					<a href="{$HOME}martial-arts-gyms/{$business->id}/" class="--clickable link tc-gun-metal push-t-sml text-sml" style="display: inline-block; white-space: nowrap;"  data-property="listing" data-property_sub_type="discipline-and-more-link" data-b_id="{$business->id}" data-ip="{$ip}">— more</a>
					{/if}
				{/foreach}
			</div>
		</div>
		<div class="right-container">
			<a class="btn view-profile-button bg-deep-blue text-med-heavy push-t-med tc-white --clickable" href="{$HOME}martial-arts-gyms/{$business->id}/" data-property="listing" data-property_sub_type="view-profile" data-b_id="{$business->id}" data-ip="{$ip}">View Profile</a>
		</div>
	<div class="clear"></div>
</div>
