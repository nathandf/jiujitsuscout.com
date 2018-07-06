<div id="sidebar-promo" class="sidebar-promo-form">
    <p class="push-t push-b text-xxlrg"><b>Exclusive Trial Offer!</b></p>
    <div class="clear"></div>
    <p class="push-t text-lrg">{$business->promotional_offer}</p>
    <div class="clear first"></div>
    {if !empty($error_messages.sidebar_promo)}
        {foreach from=$error_messages.sidebar_promo item=message}
            <div class="con-message-failure mat-hov cursor-pt --c-hide">
                <p class="user-message-body">{$message}</p>
            </div>
        {/foreach}
    {/if}
    <form method="post" action="#sidebar-promo">
        <input type="hidden" name="token" value="{$csrf_token}">
        <input type="hidden" name="sidebar_promo" value="{$csrf_token}">
        <input class="inp field-med first" name="name" value="{$inputs.sidebar_promo.name|default:null}" type="text" placeholder="Name"/>
        <input class="inp field-med" name="email" value="{$inputs.sidebar_promo.email|default:null}" type="text" placeholder="Email"/>
        <input class="inp field-med" name="number" value="{$inputs.sidebar_promo.number|default:null}" type="text" placeholder="Phone Number"/>
        <input class="btn btn-cnt button-med bg-burnt-orange" name="promo_request" type="submit"
               value="YES, I WANT THIS DEAL! >>"/>
    </form>
</div>
