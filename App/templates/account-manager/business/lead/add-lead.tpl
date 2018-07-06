<!DOCTYPE html>
<html>
	<head>
		{include file="includes/head/account-manager-head.tpl"}
		<link rel="stylesheet" type="text/css" href="{$HOME}css/leads.css"/>
	</head>
	<body>
		{include file="includes/navigation/business-manager-login-menu.tpl"}
	    {include file="includes/navigation/business-manager-menu.tpl"}
		<div class="encapsulation-cnt-bare bg-white std-bdr-salmon first inner-pad-med">
			<p class="encap-header bg-salmon tc-white">Add Lead</p>
			{if !empty($error_messages.add_lead)}
				{foreach from=$error_messages.add_lead item=message}
					<div class="con-message-failure mat-hov cursor-pt --c-hide">
						<p class="user-message-body">{$message}</p>
					</div>
				{/foreach}
			{/if}
			<form class="first" method="post" action="">
				<input type="hidden" name="token" value="{$csrf_token}">
				<input type="hidden" name="add_lead" value="{$csrf_token}">
				<lable>First Name</lable><br>
				<input type="text" class="inp field-sml" name="first_name" value="{$inputs.add_lead.first_name|default:null}"><br>
				<lable>Last Name</lable><br>
				<input type="text" class="inp field-sml" name="last_name" value="{$inputs.add_lead.last_name|default:null}"><br>
				<lable>Email</lable><br>
				<input type="text" class="inp field-sml" name="email" value="{$inputs.add_lead.email|default:null}"><br>
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
				<input type="text" class="inp field-sml" name="number" value="{$inputs.add_lead.number|default:null}"><br>
				<input id="appointment-checkbox" class="cursor-pt first last" name="schedule_appointment" type="checkbox" value="true"><label for="appointment-checkbox"> Schedule an appointment?</label>

				<input type="submit" class="btn btn-cnt first" name="add-lead" value="Create Lead +">
			</form>
		</div>
  </body>
</html>
