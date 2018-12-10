{extends file="layouts/business-manager-core.tpl"}

{block name="bm-head"}
	<link type="text/css" rel="stylesheet" href="{$HOME}public/css/partner-lead.css">
{/block}

{block name="bm-body"}
{include file="includes/navigation/business-manager-sub-menu.tpl"}
	<div class="con-cnt-xxlrg push-t-med inner-pad-med">
		<p class="text-med-heavy"><a class="tc-deep-blue link" href="{$HOME}account-manager/business/">{$business->business_name}</a> > <a class="tc-deep-blue link" href="{$HOME}account-manager/business/leads">Leads</a> > <a class="tc-deep-blue link" href="{$HOME}account-manager/business/lead/{$lead->id}/">{$lead->getFullName()}</a> > Edit</p>
		{if !empty($error_messages.edit)}
			{foreach from=$error_messages.edit item=message}
				<div class="con-message-failure mat-hov cursor-pt --c-hide">
					<p class="user-message-body">{$message}</p>
				</div>
			{/foreach}
		{/if}
		<h2 class="push-t-med push-b-med">Edit Lead Details</h2>
		<form method="post" action="">
			<input type="hidden" name="token" value="{$csrf_token}">
			<input type="hidden" name="update_prospect" value="{$csrf_token}">
			<label class="text-sml">First name</label><br>
			<input type="text" class="inp field-sml" name="first_name" value="{$lead->first_name}">
			<div class="clear push-t-med"></div>
			<label class="text-sml">Last name</label><br>
			<input type="text" class="inp field-sml" name="last_name" value="{$lead->last_name}">
			<div class="clear push-t-med"></div>
			<label class="text-sml">Email</label><br>
			<input type="text" class="inp field-sml" name="email" value="{$lead->email}">
			<div class="clear push-t-med"></div>
			<label class="text-sml">Country Code</label><br>
			<select class="inp field-sml cursor-pt" id="country_code" name="country_code"/>
				{if $phone->country_code != null}
				<option selected="selected" value="{$phone->country_code}">+{$phone->country_code}</option>
				{else}
				<option selected="selected" hidden="hidden" value="">-- Choose Code --</option>
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
			<label class="text-sml">Phone number</label><br>
			<input type="text" class="inp field-sml" name="phone_number" value="{$phone->national_number|default:null}">
			<div class="clear push-t-med"></div>
			<label class="text-sml">Address</label><br>
			<input type="text" class="inp field-sml" name="address_1" value="{$lead->address_1}" placeholder="123 Anywher St.">
			<input type="text" class="inp field-sml" name="address_2" value="{$lead->address_2}" placeholder="Ex. Apt #123">
			<div class="clear push-t-med"></div>
			<label class="text-sml">City</label><br>
			<input type="text" class="inp field-sml" name="city" value="{$lead->city}" placeholder="City">
			<div class="clear push-t-med"></div>
			<label class="text-sml">Region</label><br>
			<input type="text" class="inp field-sml" name="region" value="{$lead->region}" placeholder="State/Region/Province">
			<div class="clear"></div>
			<input type="submit" class="btn bnt-inline floatleft push-r push-t-med" value="Update Lead">
		</form>
		<div class="clear"></div>
	</div>
{/block}
