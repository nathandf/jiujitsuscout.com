<!DOCTYPE html>
<html>
	<head>
		{include file="includes/head/account-manager-head.tpl"}
		<link rel="stylesheet" type="text/css" href="{$HOME}public/css/leads.css"/>
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
					<input type="hidden" name="country_code" value="{if $country_code}{$country_code}{else}1{/if}">
					<div class="clear push-t-med"></div>
					<label class="text-sml">Phone Number</label><br>
					<input type="text" class="inp field-sml" name="number" value="{$inputs.add_lead.number|default:null}"><br>
					<div class="clear push-t-med"></div>
					<label class="text-sml">Source</label><br>
					<select name="source" class="inp field-sml cursor-pt">
						<option value="" selected="selected" hidden="hidden"></option>
						<option value="jiujitsuscout">JiuJitsuScout</option>
						<option value="facebook">Facebook</option>
						<option value="google">Google</option>
						<option value="walk-in">Walk-in</option>
						<option value="referral">Referral</option>
						<option value="other">Other</option>
						<option value="unknown">Unknown</option>
					</select>
					<div class="clear push-t-med"></div>
					<p class="text-med tc-deep-blue --c-advanced-options cursor-pt">Advanced options ></p>
					<div style="display: none;" id="advanced-options" class="push-t-med push-b-med">
						<input id="appointment-checkbox" class="cursor-pt checkbox floatleft" name="schedule_appointment" type="checkbox" value="true">
						<label class="text-med floatleft" for="appointment-checkbox"> Schedule an appointment?</label>
						<div class="clear"></div>
						<p class="text-lrg-heavy push-b-med push-t-med">Add to groups</p>
						{foreach from=$groups item=group}
						<input id="group-cb-{$group->id}" class="cursor-pt checkbox floatleft" type="checkbox" name="group_ids[]" value="{$group->id}">
						<label class="floatleft" for="group-cb-{$group->id}">{$group->name|capitalize}</label>
						<div class="clear"></div>
						{/foreach}
					</div>
					<input type="submit" class="btn btn-cnt push-t-med" name="add-lead" value="Create Lead +">
				</form>
			</div>
		</div>
  </body>
</html>
