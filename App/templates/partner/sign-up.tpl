<!DOCTYPE html>
<html>
	<head>
		<title>Sign Up</title>
    	{include file='includes/head/main-head.tpl'}
		<link rel="stylesheet" type="text/css" href="{$HOME}public/css/sign-up.css"/>
		{$facebook_pixel|default:null}
	</head>
	<body>
		{include file="includes/loading-screens/account-creation.tpl"}
    	{include file='includes/navigation/main-menu.tpl'}
		<p class="title">Create your account</p>
		<div class="con-cnt-med-plus-plus inner-pad-med border-std bg-white push-t-med push-b-lrg">
			{if !empty($error_messages.create_account)}
				{foreach from=$error_messages.create_account item=message}
					<div class="con-message-failure mat-hov cursor-pt --c-hide">
						<p class="user-message-body">{$message}</p>
					</div>
				{/foreach}
			{/if}
			<form action="" method="post" id="create-account">
				<input type="hidden" name="token" value="{$csrf_token}">
				<input type="hidden" name="create_account" value="{$csrf_token}">
				<input type="hidden" name="country_code" value="{if isset($country)}{$country->phonecode}{else}1{/if}">
				<p class="label">Gym name</p>
				<input type="text" class="inp inp-full" id="gym-name" name="gym_name" value="{if isset($gym_name)}{$gym_name}{else}{$inputs.create_account.gym_name|default:null}{/if}" required="required"/>
				<div class="clear push-t-med"></div>
				<p class="label">Name</p>
				<input type="text" class="inp inp-full" id="first_name" name="name" value="{$inputs.create_account.name|default:null}" required="required"/>
				<div class="clear push-t-med"></div>
				<p class="label">Email</p>
				<input type="email" class="inp inp-full" id="email" name="email" value="{$inputs.create_account.email|default:null}" required="required"/>
				<div class="clear push-t-med"></div>
				<p class="label">Phone number</p>
				<input type="text" class="inp inp-full" id="phone_number" name="phone_number" value="{$inputs.create_account.phone_number|default:null}" required="required"/>
				<div class="clear push-t-med"></div>
				<p class="label">Password</p>
				<input type="password" class="inp inp-full" id="password" name="password" required="required"/>
				<div class="clear push-t-med"></div>
				<input type="hidden" name="terms_conditions_agreement" value="true"><label class="text-sml">By pressing "Create Account", you accept and agree to the<br><a target="_blank" href="{$HOME}terms-and-conditions">Terms and Conditions</a> and <a target="_blank" href="{$HOME}privacy-policy">Privacy Policy</a></label>
				<div class="clear last"></div>
				<input type="submit" class="button push-t-med" name="button" value="Create Account"/>
			</form>
		</div>
    {include file='includes/footer.tpl'}
	</body>
</html>
