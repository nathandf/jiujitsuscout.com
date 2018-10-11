{extends file="layouts/business-profile.tpl"}

{block name="business-profile-head"}
	<title>{$business->business_name|capitalize} - Martial arts {if isset($business->city) && isset($business->region)}in {$business->city}, {$business->region}{/if}</title>
	<link rel="stylesheet" href="{HOME}public/css/questionnaire.css">
	<script src="{$HOME}{$JS_SCRIPTS}QuestionnaireDispatcher.js"></script>
	<script src="{$HOME}{$JS_SCRIPTS}business-profile.js"></script>
	<script type="application/ld+json">
	{literal}
		{
			"@context": "http://schema.org",
			"@type": "LocalBusiness",
			"name": "{/literal}{$business->business_name}{literal}",
			"description": "{/literal}{$business->message}{literal}",
			"image": "https://www.jiujitsuscout.com/public/img/uploads/{/literal}{$business->logo_filename}{literal}",
			"address": {
				"@type": "PostalAddress",
				"addressLocality": "{/literal}{$business->city}{literal}",
				"addressRegion": "{/literal}{$business->region}{literal}",
				"streetAddress": "{/literal}{$business->address_1}{literal}"
			},
			"geo": {
				"@type": "GeoCoordinates",
				"latitude": "{/literal}{$business->latitude|default:null}{literal}",
				"longitude": "{/literal}{$business->longitude|default:null}{literal}"
			},
			"aggregateRating": {
				"@type": "AggregateRating",
				"ratingValue": "{/literal}{$business_rating}{literal}",
				"reviewCount": "{/literal}{$total_ratings}{literal}"
			},
			"reviews": [
				{/literal}
					{if $business->reviews|@count > 0}
						{foreach from=$business->reviews item=review name=review_schema}
						{
							"@type": "Review",
							"datePublished": "{$review->datetime|date_format:"%A, %b %e %Y %l:%M%p"}",
							"reviewBody": "{$review->review_body}",
							"reviewRating": {
								"ratingValue": {$review->rating}
							},
							"author": {
								"@type": "Person",
								"name": "{$review->name}"
							}
						}{if !$smarty.foreach.review_schema.last},{/if}
						{/foreach}
					{/if}
				{literal}
			]
		}
	{/literal}
	</script>
{/block}

{block name="business-profile-body"}
	{include file="includes/modals/register.tpl"}
	{include file="includes/modals/business-images-lightbox.tpl"}
	{include file="includes/modals/reviews-lightbox.tpl"}
	<div>
		<div class="col-100 inner-pad-med">
			{if !empty($error_messages.capture)}
				{foreach from=$error_messages.capture item=message}
					<div class="con-message-failure mat-hov cursor-pt --c-hide">
						<p class="user-message-body">{$message}</p>
					</div>
				{/foreach}
			{/if}
			<div class="business-logo-container floatleft push-r-med">
				<img alt="{$business->business_name}'s logo - Martial Arts classes in {$business->city}, {$business->region}" src="{$HOME}public/img/uploads/{$business->logo_filename}" class="business-logo"/>
			</div>
			<div class="floatleft">
				<div class="testimonials-gym-rating">
					<p style="color: #333;"><span>{$business->business_name}</span></p>
					<div>
						<p>{$html_stars}</p>
						<p class="testimonials-gym-rating-sub-headline"><span>{$business_rating}</span> stars based on <span>{$total_ratings}</span> reviews</p>
					</div>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="col-100 inner-pad-med">
			{if $business->message != null}
			<div style="padding: 20px 0px 20px 0px; border-top: 1px solid #CCCCCC; border-bottom: 1px solid #CCCCCC;">
				<button class="btn btn-inline floatright bg-deep-blue text-med-heavy register-button" style="margin-bottom: 0;">Free Class</button>
				<button class="btn btn-inline --q-trigger floatleft contact-business-button" style="margin-bottom: 0;">Contact Gym</button>
				<div class="clear"></div>
			</div>
			<div class="">
				<p class="text-xlrg-heavy push-b push-t-med" style="color: #333;">About this gym:</p>
				<p class="text-med-heavy" style="color: #333;"><span>{$business->message}</span></p>
			</div>
			{else}
			<div style="padding: 20px 0px 20px 0px; border-top: 1px solid #CCCCCC; border-bottom: 1px solid #CCCCCC;">
				<button class="btn btn-inline floatright bg-deep-blue text-med-heavy register-button" style="margin-bottom: 0;">Free Class</button>
				<button class="btn btn-inline --q-trigger floatleft contact-business-button" style="margin-bottom: 0;">Contact Gym</button>
				<div class="clear"></div>
			</div>
			{/if}
			{if $business->disciplines|@count > 0 }
				<div class="push-b-med">
					<p class="text-xlrg-heavy push-b push-t-med" style="color: #333;">Classes:</p>
					{foreach from=$business->disciplines item=discipline}
						<p class="push-r cursor-pt push-t" style="display: inline-block; padding: 2px 5px 2px 5px; border: 1px solid #666; border-radius: 4px; color: #666;">{$discipline->nice_name}</p>
					{/foreach}
				</div>
			{/if}
			{if $business->programs|@count > 0}
				<div class="push-b-med">
					<p class="text-xlrg-heavy push-b push-t-med" style="color: #333;">Programs:</p>
					{foreach from=$business->programs item=program}
						<p class="push-r cursor-pt push-t" style="display: inline-block; padding: 2px 5px 2px 5px; border: 1px solid #666; border-radius: 4px; color: #666;">{$program|capitalize}</p>
					{/foreach}
				</div>
			{/if}
			{if $images|@count > 0}
				<div class="push-b-med">
					<p class="text-xlrg-heavy push-b push-t-med" style="color: #333;">Photos:</p>
					{foreach from=$images item=image name=image_loop}
						{if $smarty.foreach.image_loop.iteration <= 4}
						<img class="cursor-pt mat-hov business-images-lightbox-link" style="max-height: 100px; border: 1px solid #CCC; border-radius: 3px;" src="{$HOME}public/img/uploads/{$image->filename}" alt="{$image->alt|default:null}">
						{elseif $smarty.foreach.image_loop.iteration == 5}
						<div class="clear"></div>
						<a class="link text-med tc-deep-blue business-images-lightbox-link">— view more</a>
						{/if}
					{/foreach}
				</div>
			{/if}
		</div>
	</div>
	<div class="col-100 inner-pad-med">
		{if $business->reviews|@count > 0}
			<p class="text-xlrg-heavy" style="color: #333;">Reviews:</p>
			<div class="testimonials">
				<div id="comments" >
					{foreach from=$business->reviews item=review name=review_loop}
						{if $smarty.foreach.review_loop.iteration <= 3}
							<div class="testimonial-seperator"></div>
								<p class="com">
									<span class="reviewer-icon">{$review->name|substr:0:1|upper}</span><div class="reviewer-info-container"><span><span class="reviewer-name">{$review->name}</span></span>
									<br>
									<span>{$review->html_stars}</span>
									<br>
									<span class="review-date">Reviewed on:
										<span>{$review->datetime|date_format:"%A, %b %e %Y %l:%M%p"}</span></div>
										<div class="clear"></div>
									</span>
								</p>
								<div class="testimonial" style="color: #000000;">
									<p style="margin: 5px;">
										<span class="review-body">{$review->review_body}</span>
									</p>
								</div>

						{elseif $smarty.foreach.review_loop.iteration == 4}

							<a class="link push-b tc-deep-blue reviews-lightbox-link">— see more reviews</a>
							<div class="clear push-t"></div>
						{/if}
					{/foreach}
				</div><!-- end comments -->
			</div><!-- end testimonials -->
			<div class="clear"></div>
			<div style="padding: 20px 0px 20px 0px; border-top: 1px solid #CCCCCC; border-bottom: 1px solid #CCCCCC;">
				<button class="btn btn-inline floatright bg-deep-blue text-med-heavy register-button" style="margin-bottom: 0;">Free Class</button>
				<button class="btn btn-inline --q-trigger floatleft contact-business-button" style="margin-bottom: 0;">Contact Gym</button>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
		{/if}
		{include file="includes/widgets/js-google-map.tpl"}
		{if $faqAnswers|@count > 0}
		<p class="text-xlrg-heavy push-b push-t-med" style="color: #333;">Frequently Asked Questions:</p>
		<table class="push-t-med">
			{foreach from=$faqAnswers item=faqAnswer}
			<tr class="push-t-med">
				<td style="vertical-align: top;">
					<p class="text-lrg-heavy push-r">Q:</p>
				</td>
				<td>
					<p class="text-lrg-heavy">{$faqAnswer->faq->text}</p>
				</td>
			</tr>
			<tr>
				<td style="vertical-align: top;">
					<p class="text-lrg push-r">A:</p>
				</td>
				<td>
					<p class="text-lrg">{$faqAnswer->text}</p>
				</td>
			<tr>
			{/foreach}
		</table>
		{/if}
		<div class="clear"></div>
	</div>
{/block}
