{extends file="layouts/business-profile.tpl"}

{block name="business-profile-head"}
	<link rel="stylesheet" href="{HOME}public/css/questionnaire.css">
	<script src="{$HOME}{$JS_SCRIPTS}QuestionnaireDispatcher.js"></script>
	{$facebook_pixel|default:""}
{/block}

{block name="business-profile-body"}
	<div class="col-100 inner-pad-med">
		<div class="business-logo-container floatleft push-r-med">
			<img itemprop="image" alt="{$business->business_name}'s logo - Martial Arts classes in {$business->city}, {$business->region}" src="{$HOME}public/img/uploads/{$business->logo_filename}" class="business-logo"/>
		</div>
		<div class="floatleft" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
			<div class="testimonials-gym-rating">
				<p>{$business->business_name}</p>
				<p>{$html_stars}</p>
				<p class="testimonials-gym-rating-sub-headline"><span itemprop="ratingValue">{$business_rating}</span> stars based on <span itemprop="reviewCount">{$total_ratings}</span> reviews</p>
			</div>
		</div>
		<div class="clear"></div>
	</div>
	<div class="inner-pad-med" style="border-top: 1px solid #CCCCCC; border-bottom: 1px solid #CCCCCC;">
		<a class="btn btn-inline floatright bg-deep-blue text-lrg" href="{$HOME}martial-arts-gyms/{$business->site_slug}/free-class" style="margin-bottom: 0;">Free Class</a>
		<button class="btn btn-inline --q-trigger floatleft contact-business-button" style="margin-bottom: 0;">Contact Gym</button>
		<div class="clear"></div>
	</div>
	<div class="col-100 inner-pad-med">
		{if $business->disciplines|@count > 0}
			<div class="push-b-med">
				<p class="text-xlrg push-b push-t-med">Classes:</p>
				{foreach from=$business->disciplines item=discipline}
					<p class="push-r --q-trigger cursor-pt push-t" style="display: inline-block; padding: 2px 5px 2px 5px; border: 1px solid #666; border-radius: 4px; color: #666;">{$discipline->nice_name}</p>
				{/foreach}
			</div>
		{/if}
		{if $business->programs|@count > 0}
			<div class="push-b-med">
				<p class="text-xlrg push-b push-t-med">Programs:</p>
				{foreach from=$business->programs item=program}
					<p class="push-r --q-trigger cursor-pt push-t" style="display: inline-block; padding: 2px 5px 2px 5px; border: 1px solid #666; border-radius: 4px; color: #666;">{$program|capitalize}</p>
				{/foreach}
			</div>
		{/if}
	</div>
	<div class="clear"></div>
	<div class="col-100" style="border-top: 1px solid #CCC;">
		<div class="testimonials">
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
	<div class="clear"></div>
	<div class="inner-pad-med" style="border-top: 1px solid #CCCCCC; border-bottom: 1px solid #CCCCCC;">
		<a class="btn btn-inline floatright bg-deep-blue text-lrg" href="{$HOME}martial-arts-gyms/{$business->site_slug}/free-class" style="margin-bottom: 0;">Free Class</a>
		<button class="btn btn-inline --q-trigger floatleft contact-business-button" style="margin-bottom: 0;">Contact Gym</button>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
	{include file="includes/widgets/js-google-map.tpl"}
	<div class="clear"></div>

	<div id="review" class="inner-pad-med">
		<h2 class="push-b-med">Leave a Review and Rate your experience!</h2>
		{if isset($error_messages.review)}
			{foreach from=$error_messages.review item=message}
				<div class="con-message-failure mat-hov cursor-pt --c-hide">
					<p class="user-message-body">{$message}</p>
				</div>
			{/foreach}
		{/if}
		<form method="post" id="comment-form" action="{$HOME}martial-arts-gyms/{$business->site_slug}/#review-box">
			<input type="hidden" name="token" value="{$csrf_token}">
			<input type="hidden" name="rate_review" value="{$csrf_token}">
			<select form="comment-form" name="rating" class="inp field-sml cursor-pt">
				<option value="5"><p>Great! - 5</p></option>
				<option value="4"><p>Good - 4</p></option>
				<option value="3"><p>Okay - 3</p></option>
				<option value="2"><p>Not so good - 2</p></option>
				<option value="1"><p>Not Good - 1</p></option>
			</select>
			<div class="clear push-t-med"></div>
			<input type="text" name="name" class="inp field-sml push-t" value="{$inputs.rate_review.name|default:null}" placeholder="Name">
			<input type="email" name="email" class="inp field-sml push-t" value="{$inputs.rate_review.email|default:null}" placeholder="Email">
			<div class="clear push-t-med"></div>
			<textarea style="padding: 10px; box-sizing: border-box; text-indent: 0px;" class="inp field-med-plus-plus-tall" name="review" placeholder="How was your experience with {$business->business_name}?">{$inputs.rate_review.review|default:null}</textarea>
			<div class="clear"></div>
			<input type="submit" class="btn btn-inline push-t-med" name="visitor_review" value="Post Review"/>
		</form>
	</div>
{/block}
