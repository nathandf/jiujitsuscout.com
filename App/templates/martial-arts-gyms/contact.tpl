<!DOCTYPE html>
<html>
<head>
    {include file='includes/head/main-head.tpl'}
    <link rel="stylesheet" type="text/css" href="{$HOME}css/ma-profile-main.css"/>
    {$facebook_pixel|default:""}
</head>
<body>
<div id="content" class="" itemscope itemtype="http://schema.org/LocalBusiness">
    {include file='includes/snippets/profile-title-bar.tpl'}
    {include file='includes/navigation/martial-arts-gym-nav.tpl'}
    <h2 class="page-title">Contact Us</h2>
    <div class="contact-us-container">
        <div class="contact-us-header"><p>Have questions?<br>Contact us below and we will get in touch with you right
                away!</p></div>
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
            <p class="contact-us-input-label">Name:</p>
            <input type="text" name="name" value="{$inputs.contact.name|default:null}" class="inp field-med encapsulate push-l">
            <div class="clear"></div>
            <p class="contact-us-input-label">Email:</p>
            <input type="text" name="email" value="{$inputs.contact.email|default:null}" class="inp field-med encapsulate push-l">
            <div class="clear"></div>
            <p class="contact-us-input-label">Phone Number:</p>
            <input type="text" name="number" value="{$inputs.contact.number|default:null}" class="inp field-med encapsulate push-l">
            <div class="clear"></div>
            <p class="contact-us-input-label">Message:</p>
            <textarea name="message" class="inp textbox-med encapsulate push-l">{$inputs.contact.message|default:null}</textarea>
            <div class="clear"></div>
            <input type="submit" name="contact_us" class="btn button-med bg-mango push-l" value="Contact Us">
        </form>
    </div><!-- end contact-us-container -->
    {include file='includes/forms/sidebar-promo-form.tpl'}
    <div class="clear"></div>
    <div id="school-info-box">
        <p>Come by for your <a href="{$HOME}martial-arts-gyms/{$business->site_slug}/free-class">free trial class!</a>
        </p>
        {include file='includes/snippets/js-google-map.tpl'}
        <div class="clear"></div>
        <p>{$business->address_1}{if $business->address_2} {$business->address_2}{/if}, {$business->city}
            , {$business->region} {$business->postal_code}</p>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div><!-- end content -->
</body>
</html>
