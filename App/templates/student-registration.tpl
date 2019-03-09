{extends file="layouts/core.tpl"}

{block name="head"}
	<title>Sign Up</title>
	<link rel="stylesheet" type="text/css" href="{$HOME}public/css/sign-up.css"/>
	<script src="{$HOME}{$JS_SCRIPTS}QuestionnaireDispatcher.js"></script>
	<link rel="stylesheet" href="{HOME}public/css/questionnaire.css">
	{* questionnaire widget must be instatiated in the head before loading the logic for displaying it*}
	{include file="includes/widgets/questionnaire.tpl"}
	<script src="{$HOME}{$JS_SCRIPTS}student-registration.js"></script>
{/block}

{block name="body"}
	{include file='includes/navigation/main-menu.tpl'}
	<p class="title title-h2 push-t-med">Almost finished</p>
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
			<input type="hidden" name="terms_conditions_agreement" value="true"><label class="text-sml">By pressing "Complete registration", you accept and agree to the<br><a target="_blank" href="{$HOME}terms-and-conditions">Terms and Conditions</a> and <a target="_blank" href="{$HOME}privacy-policy">Privacy Policy</a></label>
			<div class="clear last"></div>
			<input type="submit" class="button push-t-med" name="button" value="Complete registration"/>
		</form>
	</div>
{/block}

{block name="footer"}
	{include file='includes/footer.tpl'}
{/block}
