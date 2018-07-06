<!DOCTYPE html>
<html>
	<head>
		{include file="includes/head/account-manager-head.tpl"}
	 <link type="text/css" rel="stylesheet" href="{$HOME}css/partner-lead.css">
	</head>
	<body>
		{include file="includes/navigation/business-manager-login-menu.tpl"}
    {include file="includes/navigation/business-manager-menu.tpl"}
    {include file="includes/navigation/business-manager-menu-mobile.tpl"}
		<div class="con-cnt-xlrg first inner-pad-med">
			<a class="btn btn-inline bg-dark-mint text-med first" href="{$HOME}account-manager/business/member/{$member->id}/">< Member Manager</a>
			{if !empty($error_messages.edit_member)}
				{foreach from=$error_messages.edit_member item=message}
					<div class="con-message-failure mat-hov cursor-pt --c-hide">
						<p class="user-message-body">{$message}</p>
					</div>
				{/foreach}
			{/if}
			<form method="post" action="">
				<input type="hidden" name="token" value="{$csrf_token}">
				<input type="hidden" name="update_member" value="{$csrf_token}">
				<h2 class="first last">Member Details</h2>
				<label>First name</label><br>
				<input type="text" class="inp field-sml" name="first_name" value="{$member->first_name}">
				<div class="clear"></div>
				<label>Last name</label><br>
				<input type="text" class="inp field-sml" name="last_name" value="{$member->last_name}">
				<div class="clear"></div>
				<label>Email</label><br>
				<input type="text" class="inp field-sml" name="email" value="{$member->email}">
				<div class="clear"></div>
				<lable>Country Code</lable><br>
				<select class="inp field-sml cursor-pt" id="country_code" name="country_code"/>
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
				<div class="clear"></div>
				<label>Phone number</label><br>
				<input type="text" class="inp field-sml" name="phone_number" value="{$phone->national_number|default:null}">
				<div class="clear"></div>
				<label>Address</label><br>
				<input type="text" class="inp field-sml" name="address_1" value="{$member->address_1}" placeholder="123 Anywher St.">
				<input type="text" class="inp field-sml" name="address_2" value="{$member->address_2}" placeholder="Ex. Apt #123">
				<div class="clear"></div>
				<label>City</label><br>
				<input type="text" class="inp field-sml" name="city" value="{$member->city}" placeholder="City">
				<div class="clear"></div>
				<label>Region</label><br>
				<input type="text" class="inp field-sml" name="region" value="{$member->region}" placeholder="State/Region/Province">
				<div class="clear"></div>
				<input type="submit" class="btn bnt-inline first floatleft push-r" value="Update Member">
			</form>
			<form method="post" action="">
				<input type="hidden" name="token" value="{$csrf_token}">
				<input type="hidden" name="trash" value="{$csrf_token}">
				<input type="hidden" name="member_id" value="{$member->id}">
				<button type="submit" class="btn btn-inline bg-red first push-l floatleft --c-trash"><i class="fa fa-trash" aria-hidden="true"></i></button>
			</form>
			<div class="clear"></div>
		</div>
  </body>
</html>
