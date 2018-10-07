<div style="display: none; overflow-y: scroll;" class="lightbox reviews-lightbox inner-pad-med">
	<p class="reviews-lightbox-close floatright cursor-pt tc-white"><i class="fa fa-2x fa-times" aria-hidden="true"></i></p>
	<div class="clear push-t-lrg"></div>
	<div class="testimonials bg-white inner-pad-med">
		<h2>Reviews:</h2>
		<div id="comments" >
			{foreach from=$business->reviews item=review name=review_loop}
				<div class="testimonial-seperator"></div>
				<span itemprop="review" itemscope itemtype="http://schema.org/Review">
					<meta itemprop="itemReviewed" content="{$business->business_name}">
					<p class="com">
						<span class="reviewer-icon">{$review->name|substr:0:1|upper}</span><div class="reviewer-info-container"><span itemprop="author"><span class="reviewer-name">{$review->name}</span></span>
						<br>
						<span itemprop="reviewRating">{$review->html_stars}</span>
						<br>
						<span class="review-date">Reviewed on:
							<span itemprop="datePublished">{$review->datetime|date_format:"%A, %b %e %Y %l:%M%p"}</span></div>
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
</div>
