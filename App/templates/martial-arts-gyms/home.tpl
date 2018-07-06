<!DOCTYPE html>
<html>
	<head>
		{include file='includes/head/main-head.tpl'}
		<link rel="stylesheet" type="text/css" href="{$HOME}css/ma-profile-main.css"/>
		{$facebook_pixel|default:""}
	</head>
	<body>
		{include file='includes/navigation/martial-arts-gym-nav-mobile.tpl'}
		<div id="content" itemscope itemtype="http://schema.org/LocalBusiness">
			{include file='includes/snippets/profile-title-bar.tpl'}
			{include file='includes/navigation/martial-arts-gym-nav.tpl'}
			<div class="sub-header">
				<div id="slides">
					<div class="slide-image" style="background: url('{$HOME}img/bttplano800.jpg'); background-size: 100%; "></div>
				</div>
			</div>
			<div class="con-cnt-xxlrg">
				<div class="col col-2">
					<h2 class="header-1">{$business->title}</h2>
					<div class="clear"></div>
					<p class="">{$business->message}</p>
				</div>
				<div class="col col-2-last">
					{*{$business->video_link}*}
				</div>
				<div class="clear"></div>
			</div>
			
				<div id="contact-us">
                    <p id="info-request-header" class="heading">Request Information</p>

                    {if !empty($error_messages.info_request)}
                        {foreach from=$error_messages.info_request item=message}
                            <div class="con-message-failure mat-hov cursor-pt --c-hide">
                                <p class="user-message-body">{$message}</p>
                            </div>
                        {/foreach}
                    {/if}
                    <form id="info-request" method="post" action="{$HOME}martial-arts-gyms/{$business->site_slug}/#info-request-header">
                        <input type="hidden" name="token" value="{$csrf_token}">
						<input type="hidden" name="info_request" value="{$csrf_token}">
                        <input class="in-capt-info" name="name" value="{$inputs.info_request.name|default:null}" type="text" placeholder="Name"/>
                        <input class="in-capt-info" name="email" value="{$inputs.info_request.email|default:null}" type="text" placeholder="Email"/>
                        <input class="in-capt-info" name="number" value="{$inputs.info_request.number|default:null}" type="text" placeholder="Phone Number"/>
                        <select class="infodrop" name="info" id="info" form="info-request">
                            <option value="Promotional Offers, Schedule, and Pricing Information" selected="selected" hidden="hidden">More Info</option>
                            <option value="Schedule">Schedule</option>
                            <option value="Promotional Offers">Promotional Offers</option>
                            <option value="Pricing">Pricing Info</option>
                            <option value="Promotional Offers, Schedule, and Pricing Information">All of the above</option>
                        </select>
                        <div class="clear"></div>
                        <input class="in-capt sub" type="submit" value="Request More Info"/>
                    </form>
                    <div class="clear"></div>
			    </div>
				<div class="clear"></div>
			<div id="school-info-box">
				<p>Come by for your <a class="link" href="{$HOME}martial-arts-gyms/{$business->site_slug}/free-class">free trial class!</a></p>
				{*{include file='includes/snippets/js-google-map.tpl'}*}
				<div class="clear"></div>
				<p>{$business->address_1}, {$business->city}, {$business->region} {$business->postal_code}</p>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
				<div id="review">
					<div id="bottom-box">
						<h2 id="comment-h">Leave a Review and Rate your experience!</h2>
						<div itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
							<div style="margin-left: 20px; font-weight: 600;">
								<p>{$business->business_name}'s Rating: <span itemprop="ratingValue">{$business_rating}</span>/ 5</p>
								<p>{$html_stars}</p>
							</div>
							<div style="margin-left: 20px; font-weight: 600;" id="reviews-link-mobile">
								<p>Reviews: <span itemprop="reviewCount">{$total_ratings}</span></p>
							</div>
							<div class="clear"></div>
						</div>
							<div id="review-box">
								<p id="rate-p">Rate Your Experience!</p>
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
									<select form="comment-form" name="rating" class="inp field-sml" id="user-rating" name="rating">
										<option value="5"><p>Great! - 5</p></option>
										<option value="4"><p>Good - 4</p></option>
										<option value="3"><p>Okay - 3</p></option>
										<option value="2"><p>Not so good - 2</p></option>
										<option value="1"><p>Not Good - 1</p></option>
									</select>
									<input type="text" name="name" class="inp field-sml" value="{$inputs.rate_review.name|default:null}" placeholder="Name" style="margin-left: 20px;">
									<input type="email" name="email" class="inp field-sml" value="{$inputs.rate_review.email|default:null}" placeholder="Email" style="margin-left: 20px;">
									<div class="clear"></div>
									<textarea class="inp field-med-plus-plus push-l" name="review" value="{$inputs.rate_review.review|default:null}" placeholder="How was your experience with {$business->business_name}?"></textarea>
									<div class="clear"></div>
									<input type="submit" class="in-capt sub" id="comment-post-button" name="visitor_review" value="Post Review"/>
								</form>
							</div>
						</div>
					</div>
			</div><!-- end content -->
	</body>
</html>
