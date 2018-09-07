{extends file="layouts/core.tpl"}

{block name="head"}

{/block}

{block name=body}
	{include file="includes/navigation/main-menu.tpl"}
	<div class="con con-cnt-xlrg push-t-lrg push-b-lrg">
		<p class="text-lrg">There was an error processing your request to unsubscribe. Either you have already been unsubscribed or there no email was specified.</p>
	</div>
{/block}

{block name=footer}
	{include file="includes/footer.tpl"}
{/block}
