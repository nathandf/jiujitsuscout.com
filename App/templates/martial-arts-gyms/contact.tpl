{extends file="layouts/business-profile.tpl"}

{block name="business-profile-head"}
	{$facebook_pixel|default:""}
{/block}

{block name="business-profile-body"}
    <h2 class="page-title">Contact Us</h2>
    <div class="contact-us-container">
        <div class="contact-us-header"><p>Have questions?<br>Contact us below and we will get in touch with you right
                away!</p></div>
		<div class="inner-pad-med">
	        {if !empty($error_messages.contact)}
	            {foreach from=$error_messages.contact item=message}
	                <div class="con-message-failure mat-hov cursor-pt --c-hide">
	                    <p class="user-message-body">{$message}</p>
	                </div>
	            {/foreach}
	        {/if}
	        <form action="{$HOME}martial-arts-gyms/{$business->site_slug}/contact" method="post">
	            <input type="hidden" name="token" value="{$csrf_token}">
	            <input type="hidden" name="contact" value="{$csrf_token}">
	            <p class="text-sml">Name:</p>
	            <input type="text" name="name" value="{$inputs.contact.name|default:null}" class="inp field-med">
	            <div class="clear push-t-med"></div>
	            <p class="text-sml">Email:</p>
	            <input type="text" name="email" value="{$inputs.contact.email|default:null}" class="inp field-med">
	            <div class="clear push-t-med"></div>
	            <p class="text-sml">Phone Number:</p>
	            <input type="text" name="number" value="{$inputs.contact.number|default:null}" class="inp field-med">
	            <div class="clear push-t-med"></div>
	            <p class="text-sml">Message:</p>
	            <textarea name="message" class="inp field-med-plus-plus-tall">{$inputs.contact.message|default:null}</textarea>
	            <div class="clear"></div>
	            <input type="submit" name="contact_us" class="btn button-med push-t-med" value="Contact Us">
	        </form>
		</div>
    </div><!-- end contact-us-container -->
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
