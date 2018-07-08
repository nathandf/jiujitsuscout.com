<!DOCTYPE html>
<html>
	<head>
		{include file='includes/head/main-head.tpl'}
		<link rel="stylesheet" type="text/css" href="{$HOME}css/ma-profile-main.css"/>
		{$facebook_pixel|default:""}
	</head>
	<body>
		{include file='includes/navigation/martial-arts-gym-top-nav.tpl'}
		<div class="con-cnt-xxlrg push-t-lrg  push-b-lrg bg-white" style="border: 1px solid #CCC;" itemscope itemtype="http://schema.org/LocalBusiness">
			{include file='includes/snippets/business-name.tpl'}
			{include file='includes/navigation/martial-arts-gym-nav.tpl'}
			<div class="content-container-16-9 bg-black">
				<img class="inner-content-container-fit" src="{$HOME}img/finisher.jpg">
			</div>
			<div class="con-cnt-xxlrg">
                <p class="title-wrapper text-xlrg-heavy push-t-med">Request Information</p>
				<div class="con-outer-fit inner-pad-med bg-deep-blue">
					{if !empty($error_messages.info_request)}
	                    {foreach from=$error_messages.info_request item=message}
	                        <div class="con-message-failure mat-hov cursor-pt --c-hide">
	                            <p class="user-message-body">{$message}</p>
	                        </div>
	                    {/foreach}
	                {/if}
					<div class="con-cnt-fit">
						<form id="info-request" method="post" action="{$HOME}martial-arts-gyms/{$business->site_slug}/#info-request-header">
		                    <input type="hidden" name="token" value="{$csrf_token}">
							<input type="hidden" name="info_request" value="{$csrf_token}">
		                    <input class="inp field-med push-t" name="name" value="{$inputs.info_request.name|default:null}" type="text" placeholder="Name"/>
		                    <input class="inp field-med push-t" name="email" value="{$inputs.info_request.email|default:null}" type="text" placeholder="Email"/>
		                    <input class="inp field-med push-t" name="number" value="{$inputs.info_request.number|default:null}" type="text" placeholder="Phone Number"/>
							<div class="clear push-t-med"></div>
							<select class="inp field-sml cursor-pt" name="info" id="info" form="info-request">
		                        <option value="Promotional Offers, Schedule, and Pricing Information" selected="selected" hidden="hidden">More Info</option>
		                        <option value="Schedule">Schedule</option>
		                        <option value="Promotional Offers">Promotional Offers</option>
		                        <option value="Pricing">Pricing Info</option>
		                        <option value="Promotional Offers, Schedule, and Pricing Information">All of the above</option>
		                    </select>
		                    <div class="clear push-t-med"></div>
		                    <input class="btn button-med btn-inline" type="submit" value="Request More Info"/>
		                </form>
					</div>
				</div>

                <div class="clear"></div>
		    </div>
			<div class="clear"></div>
			<div class="inner-pad-med">
				<p>Come by for your <a class="link" href="{$HOME}martial-arts-gyms/{$business->site_slug}/free-class">free trial class!</a></p>
				{*{include file='includes/snippets/js-google-map.tpl'}*}
				<div class="clear"></div>
				<p>{$business->address_1}, {$business->city}, {$business->region} {$business->postal_code}</p>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
			<div id="review" class="inner-pad-med">
				<h2 class="push-b-med">Leave a Review and Rate your experience!</h2>
				<div itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
					<div>
						<p>{$business->business_name}'s Rating: <span itemprop="ratingValue">{$business_rating}</span>/ 5</p>
						<p>{$html_stars}</p>
					</div>
					<div>
						<p>Reviews: <span itemprop="reviewCount">{$total_ratings}</span></p>
					</div>
					<div class="clear"></div>
				</div>
				<p class="text-med-heavy push-t-med push-b-med">Rate Your Experience!</p>
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
		</div><!-- end content -->
		{include file="includes/footer.tpl"}
	</body>
</html>
