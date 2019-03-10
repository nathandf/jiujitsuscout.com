{extends file="layouts/core.tpl"}

{block name="head"}
	<title>Registration Complete</title>
	<link rel="stylesheet" type="text/css" href="{$HOME}public/css/sign-up.css"/>
{/block}

{block name="body"}
	{include file='includes/navigation/main-menu.tpl'}
	<p class="title title-h2 push-t-med">Registration Complete!</p>
	<p class="title title-h2 push-t-med">Find marital arts gyms near you</p>
	<div class="con-cnt-med-plus-plus inner-pad-med border-std bg-white push-t-med push-b-lrg">
		{if !empty($error_messages.create_account)}
			{foreach from=$error_messages.create_account item=message}
				<div class="con-message-failure mat-hov cursor-pt --c-hide">
					<p class="user-message-body">{$message}</p>
				</div>
			{/foreach}
		{/if}
		<form action="search" method="get">
			<div class="clear push-t-med"></div>
			<p class="label">Postal Code</p>
			<input type="text" class="inp inp-full" id="first_name" name="q" value="{$inputs.create_account.name|default:null}" required="required"/>
			<div class="clear push-t-med"></div>
			<button type="submit" class="button push-t-med">Find Gyms</button>
		</form>
	</div>
{/block}

{block name="footer"}
	{include file='includes/footer.tpl'}
{/block}
