<!DOCTYPE html>
<html>
	<head>
		{include file="includes/head/account-manager-head.tpl"}
		<link rel="stylesheet" type="text/css" href="{$HOME}css/leads.css"/>
	</head>
	<body>
		{include file="includes/navigation/business-manager-login-menu.tpl"}
	    {include file="includes/navigation/business-manager-menu.tpl"}
		<div class="encapsulation-cnt-bare bg-white add-form inner-pad-med last">
			<p class="encap-header bg-green tc-white">Create new member</p>
			<a class="btn btn-inline bg-salmon text-med first" href="{$HOME}account-manager/business/member/choose-prospect">Choose from prospects</a>
			{if !empty($error_messages.register_member)}
				{foreach from=$error_messages.register_member item=message}
					<div class="con-message-failure mat-hov cursor-pt --c-hide">
						<p class="user-message-body">{$message}</p>
					</div>
				{/foreach}
			{/if}
			<form class="first" method="post" action="">
				<input type="hidden" name="token" value="{$csrf_token}">
				<input type="hidden" name="register_member" value="{$csrf_token}">
				<lable>First Name</lable><br>
				<input type="text" class="inp field-sml" name="first_name" value="{$inputs.register_member.first_name|default:null}"><br>
				<lable>Last Name</lable><br>
				<input type="text" class="inp field-sml" name="last_name" value="{$inputs.register_member.last_name|default:null}"><br>
				<lable>Email</lable><br>
				<input type="text" class="inp field-sml" name="email" value="{$inputs.register_member.email|default:null}"><br>
				<lable>Country Code</lable><br>
				<select class="inp field-sml cursor-pt" id="country_code" name="country_code"/>
					<option selected="selected" hidden="hidden" value="">-- Choose Code --</option>
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
				<lable>Phone Number</lable><br>
				<input type="text" class="inp field-sml" name="phone_number" value="{$inputs.register_member.phone_number|default:null}"><br>
				<input type="submit" class="btn btn-cnt first" name="add-member" value="Create Member +">
			</form>
		</div>
  </body>
</html>
