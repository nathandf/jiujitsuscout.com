<!DOCTYPE html>
<html>
	<head>
		{include file="includes/head/account-manager-head.tpl"}
	 <link type="text/css" rel="stylesheet" href="{$HOME}css/partner-lead.css">
	</head>
	<body>
		{include file="includes/navigation/account-manager-login-menu.tpl"}
	    {include file="includes/navigation/account-manager-menu.tpl"}
		<div class="con-cnt-xxlrg inner-box first">
			{include file="includes/navigation/account-manager-settings-menu.tpl"}
			<div class="con-cnt-xlrg push-t-med">
				<div class="inner-pad-med">
					<h2 class="h2 push-b push-t">Edit user details</h2>
					{if !empty($error_messages.edit_user)}
						{foreach from=$error_messages.edit_user item=message}
							<div class="con-message-failure mat-hov cursor-pt --c-hide">
								<p class="user-message-body">{$message}</p>
							</div>
						{/foreach}
					{/if}
					<form class="first" method="post" action="">
						<input type="hidden" name="token" value="{$csrf_token}">
						<input type="hidden" name="edit_user" value="{$csrf_token}">
						<div class="clear push-t-med"></div>
						<label class="text-sml">First name</label><br>
						<input type="text" class="inp field-sml" name="first_name" value="{$user_to_edit->first_name}">
						<div class="clear"></div>
						<div class="clear push-t-med"></div>
						<label class="text-sml">Last name</label><br>
						<input type="text" class="inp field-sml" name="last_name" value="{$user_to_edit->last_name}">
						<div class="clear"></div>
						<div class="clear push-t-med"></div>
						<label class="text-sml">Email</label><br>
						<input type="text" class="inp field-sml" name="email" value="{$user_to_edit->email}">
						<div class="clear"></div>
						<div class="clear push-t-med"></div>
						<label class="text-sml">Country Code</label><br>
						<select class="inp field-sml cursor-pt" id="country_code" name="country_code"/>
							{if $phone->country_code != null}
							<option selected="selected" value="{$phone->country_code}">+{$phone->country_code}</option>
							{else}
							<option selected="selected" hidden="hidden" value="">-- Choose Code --</option>
							{/if}
							{if isset($country_code)}
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
						<label class="text-sml">Phone number</label>
						<div class="clear"></div>
						<input type="text" class="inp field-sml" name="phone_number" value="{$phone->national_number|default:null}">
						<div class="clear"></div>
						<input type="submit" class="btn bnt-inline push-t-med" value="Update User">
					</form>
				</div>
			</div>
		</div>
	</body>
</html>
