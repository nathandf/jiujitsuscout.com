<!DOCTYPE html>
<html>
	<head>
		<title>Sign Up</title>
    	{include file='includes/head/main-head.tpl'}
		<link rel="stylesheet" type="text/css" href="{$HOME}public/css/sign-up.css"/>
		{$facebook_pixel|default:null}
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
					<input type="hidden" name="country_code" value="{if isset($country)}{$country->phonecode}{else}1{/if}">
					<input type="text" class="inp field-med" id="gym-name" name="gym_name" value="{if isset($gym_name)}{$gym_name}{else}{$inputs.create_account.gym_name|default:null}{/if}" placeholder="Gym name"/>
					<div class="clear push-t-med"></div>
					<input type="text" class="inp field-med" id="first_name" name="first_name" value="{$inputs.create_account.first_name|default:null}" placeholder="First Name"/>
					<div class="clear push-t-med"></div>
					<input type="text" class="inp field-med" id="email" name="email" value="{$inputs.create_account.email|default:null}" placeholder="Email"/>
					<div class="clear push-t-med"></div>
					<input type="text" class="inp field-med" id="phone_number" name="phone_number" value="{$inputs.create_account.phone_number|default:null}" placeholder="Phone number"/>
					<div class="clear push-t-med"></div>
					<input type="password" class="inp field-med" id="password" name="password" placeholder="Password"/>
					<div class="clear push-t-med"></div>
					<input type="password" class="inp field-med" id="confirm_password" name="confirm_password" placeholder="Confirm password"/>
					<div class="clear push-t-med"></div>
					<input type="hidden" name="terms_conditions_agreement" value="true"><label class="text-sml">By pressing "Create Account", you accept and agree to the<br><a target="_blank" href="{$HOME}terms-and-conditions">Terms and Conditions</a> and <a target="_blank" href="{$HOME}privacy-policy">Privacy Policy</a></label>
					<div class="clear last"></div>
					<input type="submit" class="btn btn-cnt button-med push-t-med" name="button" value="Create Account"/>
				</form>
			</div>
		</div>
    {include file='includes/footer.tpl'}
	</body>
</html>
