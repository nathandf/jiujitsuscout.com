{extends file="layouts/business-profile.tpl"}

{block name="business-profile-head"}
	{$facebook_pixel|default:""}
{/block}

{block name="business-profile-body"}
	<h2 class="page-title">Thank You</h2>
	<div class="thank-you-container">
		<div class="thank-you-header"><p>Thanks!</p></div>
		<div class="thank-you-message">{$thank_you_message|default:"We've recieved your request and will be in touch with you very soon!"}<br><br>Contact us at <b style="color: #444;">{$business->phone_number}</b></div>
	</div><!-- end thank-you-container -->

	<div class="clear"></div>
{/block}
