<!DOCTYPE html>
<html>
	<head>
		{include file="includes/head/account-manager-head.tpl"}
		<link rel="stylesheet" type="text/css" href="{$HOME}css/leads.css"/>
	</head>
	<body>
		{include file="includes/navigation/business-manager-login-menu.tpl"}
	    {include file="includes/navigation/business-manager-menu.tpl"}
		<div class="encapsulation-cnt-bare bg-white std-bdr-salmon first">
				<p class="encap-header bg-salmon tc-white">Add Lead</p>
				<div class="inner-pad-med">
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
					<label class="text-sml">First Name</label><br>
					<input type="text" class="inp field-sml" name="first_name" value="{$inputs.add_lead.first_name|default:null}"><br>
					<div class="clear push-t-med"></div>
					<label class="text-sml">Last Name</label><br>
					<input type="text" class="inp field-sml" name="last_name" value="{$inputs.add_lead.last_name|default:null}"><br>
					<div class="clear push-t-med"></div>
					<label class="text-sml">Email</label><br>
					<input type="text" class="inp field-sml" name="email" value="{$inputs.add_lead.email|default:null}"><br>
					<div class="clear push-t-med"></div>
					<label class="text-sml">Country Code</label><br>
					<select class="inp field-sml cursor-pt" id="country_code" name="country_code"/>
						{if $country_code}
						<option value="">-- Default Country Code --</option>
						<option value="{$country_code}" selected="selected">+{$country_code}</option>
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
					<label class="text-sml">Phone Number</label><br>
					<input type="text" class="inp field-sml" name="number" value="{$inputs.add_lead.number|default:null}"><br>
					<div class="clear push-t-med"></div>
					<input id="appointment-checkbox" class="cursor-pt push-t-med" name="schedule_appointment" type="checkbox" value="true"><label class="text-sml" for="appointment-checkbox"> Schedule an appointment?</label>
					<input type="submit" class="btn btn-cnt push-t-med" name="add-lead" value="Create Lead +">
				</form>
			</div>
		</div>
  </body>
</html>
