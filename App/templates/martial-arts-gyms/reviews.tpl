<!DOCTYPE html>
<html>
	<head>
		{include file='includes/head/main-head.tpl'}
		<link rel="stylesheet" type="text/css" href="{$HOME}css/ma-profile-main.css"/>
		{$facebook_pixel|default:""}
	</head>
	<body>
		{include file='includes/navigation/martial-arts-gym-nav-mobile.tpl'}
		<div id="content" class="" itemscope itemtype="http://schema.org/LocalBusiness">
			{include file='includes/snippets/profile-title-bar.tpl'}
			{include file='includes/navigation/martial-arts-gym-nav.tpl'}
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
			<div id="school-info-box">
				<p>Come by for your <a href="{$HOME}martial-arts-gyms/{$business->site_slug}/free-class">free trial class!</a></p>
				{include file='includes/snippets/js-google-map.tpl'}
				<div class="clear"></div>
				<p>{$business->address_1}{if $business->address_2} {$business->address_2}{/if}, {$business->city}, {$business->region} {$business->postal_code}</p>
				<div class="clear"></div>
			</div>
		</div><!-- end content -->
	</body>
</html>
