<!DOCTYPE html>
<html>
	<head>
    {include file='includes/head/main-head.tpl'}
		<link rel="stylesheet" type="text/css" href="{$HOME}css/sign-up.css"/>
	</head>
	<body>
    {include file='includes/navigation/main-menu.tpl'}
		<div class="content">
			<div class="encapsulation-cnt">
				<p class="form-title">Find more students{if isset($gym_name)} for {$gym_name}{/if}!</p>
				{if !empty($error_messages.create_account)}
					{foreach from=$error_messages.create_account item=message}
						<div class="con-message-failure mat-hov cursor-pt --c-hide">
							<p class="user-message-body">{$message}</p>
						</div>
					{/foreach}
				{/if}
				<form action="" method="post" id="submit-form">
					<input type="hidden" name="token" value="{$csrf_token}">
					<input type="hidden" name="create_account" value="{$csrf_token}">
					<input type="text" class="inp field-med" id="gym-name" name="gym_name" value="{if isset($gym_name)}{$gym_name}{else}{$inputs.create_account.gym_name|default:null}{/if}" placeholder="Gym name"/>
					<div class="clear push-t-med"></div>
					<input type="text" class="inp field-med" id="first_name" name="first_name" value="{$inputs.create_account.first_name|default:null}" placeholder="First Name"/>
					<div class="clear push-t-med"></div>
					<input type="text" class="inp field-med" id="email" name="email" value="{$inputs.create_account.email|default:null}" placeholder="Email"/>
					<div class="con-cnt-med push-t-med">
						<select class="inp field-xsml cursor-pt floatleft" id="country_code" name="country_code"/>
							{if isset($country) && isset($inputs.create_account.first_name) == false}
							<option selected="selected" hidden="hidden" value="{$country->phonecode}">+{$country->phonecode}</option>
							{/if}
							{if isset($inputs.create_account.country_code)}
							<option selected="selected" value="{$inputs.create_account.country_code}">+{$inputs.create_account.country_code}</option>
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
						<input type="text" class="inp field-sml" id="phone_number" name="phone_number" value="{$inputs.create_account.phone_number|default:null}" placeholder="Phone number"/>
					<div class="clear push-t-med"></div>
					</div>
					<input type="password" class="inp field-med" id="password" name="password" placeholder="Password"/>
					<div class="clear push-t-med"></div>
					<input type="password" class="inp field-med" id="confirm_password" name="confirm_password" placeholder="Confirm password"/>
					<div class="clear push-t-med"></div>
					<input type="checkbox" name="terms_conditions_agreement" value="true" style="margin-right: 5px;"><label class="text-sml">I have read and agree to the<br><a target="_blank" href="{$HOME}terms-and-conditions">Terms and Conditions</a> and <a target="_blank" href="{$HOME}privacy-policy">Privacy Policy</a></label>
					<div class="clear last"></div>
					<input type="submit" class="btn btn-cnt button-med push-t-med" name="button" value="Create Account"/>
				</form>
			</div>
		</div>
    {include file='includes/footer.tpl'}
	</body>
</html>
