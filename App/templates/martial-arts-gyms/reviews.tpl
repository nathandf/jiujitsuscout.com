{extends file="layouts/business-profile.tpl"}

{block name="business-profile-head"}
	{$facebook_pixel|default:""}
{/block}

{block name="business-profile-body"}
	<h2 class="page-title">Testimonials</h2>
	<p class="review-link"><a href="{$HOME}martial-arts-gyms/{$business->site_slug}/#review">Leave a Review!</a></p>
	<div class="testimonials-container">
		<div class="testimonials-header"><p>Reviews for {$business->business_name}<br>{$business->city} {$business->region}<br>Martial Arts</p></div>
		<div class="testimonials">
			<div class="testimonials-gym-rating"><p>{$business->business_name}<br>{$html_stars}</p>
				<p class="testimonials-gym-rating-sub-headline">{$business_rating} stars based on {$total_ratings} reviews</p>
			</div>
			<div id="comments" >
				{foreach from=$reviews item=review}
				<div class="testimonial-seperator"></div>
				<span itemprop="review" itemscope itemtype="http://schema.org/Review">
					<meta itemprop="itemReviewed" content="{$business->business_name}">
					<p class="com">
						<span class="reviewer-icon">{$review->name|substr:0:1|upper}</span><div class="reviewer-info-container"><span itemprop="author"><span class="reviewer-name">{$review->name}</span></span>
						<br>
						<span itemprop="reviewRating">{$review->html_stars}</span>
						<br>
						<span class="review-date">Reviewed on:
							<span itemprop="datePublished">{$review->datetime}</span></div>
							<div class="clear"></div>
						</span>
					</p>
					<div class="testimonial" style="color: #000000;">
						<p style="margin: 5px;">
							<span itemprop="reviewBody" class="review-body">{$review->review_body}</span>
						</p>
					</div>
				</span>
				{/foreach}
			</div><!-- end comments -->
		</div><!-- end testimonials -->
	</div><!-- end testimonials-container -->
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
