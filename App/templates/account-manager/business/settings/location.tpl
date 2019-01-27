{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}
	<link rel="stylesheet" type="text/css" href="{$HOME}css/partner-settings.css"/>
{/block}

{block name="bm-body"}
	{include file="includes/navigation/business-manager-sub-menu.tpl"}
	<div class="con-cnt-xxlrg inner-box push-t-med">
		{include file="includes/navigation/business-manager-settings-menu.tpl"}
		<div class="con-cnt-xlrg inner-pad-med">
			<h2 class="h2 push-t-med">Update Location</h2>
			<div class="hr-sml">
				<p class="text-sml">Updating your gym's location will affect when your listing is shown to customers.</p>
			</div>
			<div class="push-t-lrg">
				{if !empty($error_messages.update_location)}
					{foreach from=$error_messages.update_location item=message}
						<div class="con-message-failure mat-hov cursor-pt --c-hide">
							<p class="user-message-body">{$message}</p>
						</div>
					{/foreach}
				{/if}
				<form id="location" action="" method="post">
					<input type="hidden" name="token" value="{$csrf_token}">
					<input type="hidden" name="update_location" value="{$csrf_token}">
					<label class="text-sml">Address 1</label>
					<div class="clear"></div>
					<input class="inp inp-med-plus-plus" type="text" name='address_1' placeholder="123 Anywhere St"  value='{$business->address_1}'>
					<div class="clear push-t-med"></div>
					<label class="text-sml">Address 2</label>
					<div class="clear"></div>
					<input class="inp inp-med-plus-plus" type="text" name='address_2' placeholder="ex. ste 101" value='{$business->address_2}'>
					<div class="clear push-t-med push-t-med push-t-med"></div>
					<label class="text-sml">City</label>
					<div class="clear"></div>
					<input class="inp inp-med-plus-plus" type="text" name='city' placeholder="Anytown"  value='{$business->city}'>
					<div class="clear push-t-med push-t-med"></div>
					<label class="text-sml">Region/State</label>
					<div class="clear"></div>
					<input class="inp inp-med-plus-plus" type="text" name='region' value='{$business->region}'>
					<div class="clear push-t-med"></div>
					<label class="text-sml">Post Code </label>
					<div class="clear"></div>
					<input class="inp inp-med-plus-plus" type="text" name='postal_code' placeholder="Postal code" value='{$business->postal_code}'>
					<div class="clear push-t-med"></div>
					<label class="text-sml">Country </label>
					<div class="clear"></div>
					<select class="inp cursor-pt inp-sml" name="country" form="location">
						<option name="country" value='{$business->country}' selected="selected"><span class="inner_option">{$business->country}</span></option>
						{foreach from=$countries item=country}
							<option name="country" value="{$country->iso}">{$country->nicename}</option>
						{/foreach}
					</select>
					<div class="clear push-t-med"></div>
					<input type="submit" class="btn btn-inline push-t-med" value="Update Location">
				</form>

			</div>
		</div><!-- end content -->
	</div>
	<div class="clear"></div>
{/block}
