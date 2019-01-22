<!DOCTYPE html>
<html>
	<head>
		{include file="includes/head/main-head.tpl"}
		<link rel="stylesheet" type="text/css" href="{$HOME}public/css/partner-sign-in.css"/>
	</head>
	<body>
    {include file="includes/navigation/account-manager-login-menu.tpl"}
    {include file="includes/navigation/account-manager-menu.tpl"}
		<div class="encapsulation-cnt-bare bg-white add-form first">
			<p class="encap-header bg-green tc-white">Add Business</p>
			{if !empty($error_messages.add_business)}
				{foreach from=$error_messages.add_business item=message}
					<div class="con-message-failure mat-hov cursor-pt --c-hide">
						<p class="user-message-body">{$message}</p>
					</div>
				{/foreach}
			{/if}
			<form class="first" id="add-business" method="post" action="">
				<input type="hidden" name="token" value="{$csrf_token}">
				<input type="hidden" name="add_business" value="{$csrf_token}">
				<lable>Gym Name</lable><br>
				<input type="text" class="inp field-med" name="gym_name" value="{$inputs.add_business.gym_name|default:null}"><br>
				<lable>Email</lable><br>
				<input type="text" class="inp field-med" name="email" value="{$inputs.add_business.email|default:null}"><br>
				<div class="clear"></div>
				<lable>Country Code</lable><br>
				<select class="inp field-med cursor-pt" id="country_code" name="country_code"/>
					<option selected="selected" hidden="hidden" value="">-- Choose Code --</option>
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
				<lable>Phone Number</lable>
				<div class="clear"></div>
				<input type="text" class="inp field-med" name="phone" value="{$inputs.add_business.phone|default:null}">
				<div class="clear"></div>
				<label>Address 1</label>
				<input class="inp field-med" type="text" name='address_1' placeholder="123 Anywhere St"  value='{$inputs.add_business.address_1|default:null}'>
				<label>Address 2</label>
				<input class="inp field-med" type="text" name='address_2' placeholder="ex. ste 101" value='{$inputs.add_business.address_2|default:null}'>
				<label>City</label>
				<input class="inp field-med" type="text" name='city' placeholder="Anytown"  value='{$inputs.add_business.city|default:null}'>
				<label>State/Region</label>
				<input class="inp field-med" type="text" name='region' value='{$inputs.add_business.region|default:null}'>
				<label>Post Code </label>
				<input class="inp field-med" type="text" name='postal_code' placeholder="Postal code" value='{$inputs.add_business.postal_code|default:null}'>
				<label>Country </label>
				<select class="inp cursor-pt field-med" name="country_id" form="add-business">
					<option selected="selected" hidden="hidden" value="">-- Choose Country --</option>
					{foreach from=$countries item=country}
						<option name="country_id" value="{$country->id}">{$country->nicename}</option>
					{/foreach}
				</select>
				<input type="submit" class="btn btn-cnt first" name="add" value="Create Business +">
			</form>
		</div>
  </body>
</html>
