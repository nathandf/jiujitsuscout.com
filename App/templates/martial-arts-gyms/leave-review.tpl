{extends file="layouts/business-profile.tpl"}

{block name="business-profile-head"}
	{$facebook_pixel|default:""}
{/block}

{block name="business-profile-body"}
	<div class="inner-pad-med" style="border-bottom: 1px solid #CCCCCC;" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
		<div>
			<p>{$business->business_name}'s Rating: <span itemprop="ratingValue">{$business_rating}</span>/ 5</p>
			<p>{$html_stars}</p>
		</div>
		<div>
			<p>Reviews: <span itemprop="reviewCount">{$total_ratings}</span></p>
		</div>
		<div class="clear"></div>
	</div>
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
