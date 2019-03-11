<div style="padding: 20px 0px 20px 0px; border-top: 1px solid #CCCCCC; border-bottom: 1px solid #CCCCCC;">
	{if isset($is_registered)}
		{if isset($signed_up)}
		<p class="text-xlrg-heavy"><i aria-hidden="true" class="fa fa-check tc-white bg-good-green push-r-med" style="border-radius: 3px; padding: 3px;"></i>Successfully Regsitered</p>
		{else}
		<form action="" method="post">
			<input type="hidden" name="token" value={$csrf_token}>
			<input type="hidden" name="pre_registered" value="{$csrf_token}">
			<button class="btn btn-inline floatleft contact-business-button" style="margin-bottom: 0;">Reserve Free Class</button>
		</form>
		{/if}
	{else}
	<button class="btn btn-inline floatright bg-deep-blue text-med-heavy register-button" style="margin-bottom: 0;">Free Class</button>
	<button class="btn btn-inline --q-trigger floatleft --trigger-register-modal contact-business-button" style="margin-bottom: 0;">Contact Gym</button>
	{/if}
	<div class="clear"></div>
</div>
