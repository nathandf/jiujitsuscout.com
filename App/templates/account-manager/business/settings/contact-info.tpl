<!DOCTYPE html>
<html>
	<head>
		{include file="includes/head/account-manager-head.tpl"}
		<link rel="stylesheet" type="text/css" href="<?=REL?>css/partner-settings.css"/>
	</head>
	<body>
		{include file="includes/navigation/business-manager-login-menu.tpl"}
    	{include file="includes/navigation/business-manager-menu.tpl"}
		<div class="con-cnt-xxlrg inner-box first">
			{include file="includes/navigation/business-manager-settings-menu.tpl"}
			<div class="con-cnt-xlrg inner-pad-med">
				<h2 class="h2 push-t-med push-b-med">Contact Information</h2>
				<div>
					{if !empty($error_messages.update_contact_info)}
						{foreach from=$error_messages.update_contact_info item=message}
							<div class="con-message-failure mat-hov cursor-pt --c-hide">
								<p class="user-message-body">{$message}</p>
							</div>
						{/foreach}
					{/if}
					<form id="location" action="" method="post">
						<input type="hidden" name="token" value="{$csrf_token}">
						<input type="hidden" name="update_contact_info" value="{$csrf_token}">
						<label class="text-sml">Country Code</lable><br>
						<div class="clear"></div>
						<select class="inp field-med cursor-pt" id="country_code" name="country_code"/>
							{if $phone->country_code != null}
							<option selected="selected" value="{$phone->country_code}">+{$phone->country_code}</option>
							{else}
							<option selected="selected" hidden="hidden" value="">-- Choose Code --</option>
							{/if}
							{if $country_code}
							<option value="">-- Default Country Code --</option>
							<option value="{$country_code}">+{$country_code}</option>
							{/if}
							<option value="">-- Common Country Codes --</option>
							<option value="1">USA +1</option>
							<option value="1">CAN +1</option>
							<option value="44">UK +44</option>
							<option value="61">AUS +61</option>
							<option value="">-- All Country Codes --</option>
							{foreach from=$countries item=country}
							<option value="{$country->phonecode}">{if $country->iso3}{$country->iso3}{else}{$country->iso}{/if} +{$country->phonecode}</option>
							{/foreach}
						</select>
						<div class="clear push-t-med"></div>
						<label class="text-sml">Phone Number</label>
						<div class="clear"></div>
						<input class="inp field-med" type="text" name='phone_number' value='{$phone->national_number}'>
						<div class="clear push-t-med"></div>
						<label class="text-sml">Email Address</label>
						<div class="clear"></div>
						<input class="inp field-med" type="text" name='email' value='{$business->email}'>
						<div class="clear push-t-med"></div>
						<input type="submit" class="btn btn-inline push-t-med" value="Update Contact Info">
					</form>

				</div>
			</div><!-- end content -->
		</div>
		<div class="clear"></div>
	</body>

</html>
