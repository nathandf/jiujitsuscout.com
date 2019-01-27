{extends file="layouts/account-manager-core.tpl"}

{block name="am-head"}
	<link rel="stylesheet" type="text/css" href="{$HOME}public/css/partner-settings.css"/>
{/block}

{block name="am-body"}
	{include file="includes/navigation/account-manager-login-menu.tpl"}
	{include file="includes/navigation/account-manager-menu.tpl"}
	<div class="con-cnt-xxlrg bg-white mat-box-shadow push-t-med">
		{include file="includes/navigation/account-manager-settings-menu.tpl"}
		<div class="inner-pad-med">
			<h2 class="h2">Add new user</h2>
			<div class="clear push-t-med"></div>
			{if !empty($error_messages.add_user)}
				{foreach from=$error_messages.add_user item=message}
					<div class="con-message-failure mat-hov cursor-pt --c-hide">
						<p class="user-message-body">{$message}</p>
					</div>
				{/foreach}
			{/if}
			<form action="" method="post" id="add_user" >
				<input type="hidden" name="token" value="{$csrf_token}">
				<input type="hidden" name="add_user" value="{$csrf_token}" >
				<input type="text" class="inp inp-med-plus-plus" id="contact" name="first_name" value="{$inputs.add_user.first_name|default:null}" placeholder="First name" />
				<div class="clear push-t-med"></div>
				<input type="text" class="inp inp-med-plus-plus" id="contact" name="last_name" value="{$inputs.add_user.last_name|default:null}" placeholder="Last Name" />
				<div class="clear push-t-med"></div>
				<input type="text" class="inp inp-med-plus-plus" id="email" name="email" value="{$inputs.add_user.email|default:null}" placeholder="Email" />
				<div class="clear push-t-med"></div>
				<label class="text-sml">Country Code</label><br>
				<select class="inp inp-sml cursor-pt" id="country_code" name="country_code"/>
					<option selected="selected" hidden="hidden" value="">-- Country Code --</option>
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
				<input type="text" class="inp inp-med-plus-plus" id="number" name="phone_number" value="{$inputs.add_user.phone_number|default:null}" placeholder="Phone Number" />
				<div class="clear push-t-med"></div>
				<p class="password_label">Assign an account role</p>
				<select name="role"class="inp inp-sml cursor-pt" id="">
					<option value="administrator">Administrator</option>
					<option value="manager">Manager</option>
					<option value="standard">Standard</option>
				</select>
				<div class="clear push-t-med"></div>
				<p class="password_label">Create a strong password</p>
				<input type="password" class="inp inp-med-plus-plus" id="password" name="password" placeholder="New Password" />
				<input type="password" class="inp inp-med-plus-plus push-t-med" id="confirm_password" name="confirm_password" placeholder="Confirm new password" />
				<div class="clear push-t-med"></div>
				<input type="checkbox" class="checkbox" name="terms" value="{$csrf_token}"><label class="text-sml">I have read and agree to the<br><a target="_blank" href="{$HOME}terms-and-conditions">Terms and Conditions</a> and <a target="_blank" href="{$HOME}privacy-policy">Privacy Policy</a></label>
				<div class="clear last"></div>
				<input type="submit" class="btn bnt-inline bg-deep-blue" name="button"  value="Add User" color="white"/>
			</form>
		</div>
	</div>
	<div class="push-b-lrg"></div>
{/block}
