<!DOCTYPE html>
<html>
	<head>
		{include file="includes/head/account-manager-head.tpl"}
		<link rel="stylesheet" type="text/css" href="{$HOME}css/leads.css"/>
	</head>
	<body>
		{include file="includes/navigation/business-manager-login-menu.tpl"}
	    {include file="includes/navigation/business-manager-menu.tpl"}
		<div class="encapsulation-cnt-bare bg-white add-form  push-t-med push-b-med">
			<p class="encap-header bg-green tc-white">Create new member</p>
			<div class="inner-pad-med">
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
					<label class="text-sml">First Name</label><div class="clear"></div>
					<input type="text" class="inp field-sml" name="first_name" value="{$inputs.register_member.first_name|default:null}"><br>
					<div class="clear push-t-med"></div>
					<label class="text-sml">Last Name</label><div class="clear"></div>
					<input type="text" class="inp field-sml" name="last_name" value="{$inputs.register_member.last_name|default:null}"><br>
					<div class="clear push-t-med"></div>
					<label class="text-sml">Email</label><div class="clear"></div>
					<input type="text" class="inp field-sml" name="email" value="{$inputs.register_member.email|default:null}"><br>
					<input type="hidden" name="country_code" value="{if $country_code}{$country_code}{else}1{/if}">
					<div class="clear push-t-med"></div>
					<label class="text-sml">Phone Number</label><div class="clear"></div>
					<input type="text" class="inp field-sml" name="phone_number" value="{$inputs.register_member.phone_number|default:null}"><br>
					<input type="submit" class="btn btn-cnt first" name="add-member" value="Create Member +">
				</form>
			</div>
		</div>
  </body>
</html>
