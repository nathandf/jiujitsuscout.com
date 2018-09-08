{extends file="layouts/core.tpl"}

{block name="head"}

{/block}

{block name=body}
	{include file="includes/navigation/main-menu.tpl"}
	<div class="con con-cnt-xlrg push-t-lrg push-b-lrg">
		{if isset($email)}
		<p class="text-lrg">You are about to unsubscribe <span class="text-lrg-heavy">{$email|default:null}</span> from JiuJitsuScout emails. Are you sure you want to unsubscribe?</p>
		<form action="confirm" method="post">
			<input type="hidden" name="email" value="{$email|default:null}">
			<input type="submit" class="btn btn-inline push-t-med" value="Unsubscribe {$email|default:null}">
		</form>
		{else}
		<p class="text-lrg">No Email Selected</p>
		{/if}
	</div>
{/block}

{block name=footer}
	{include file="includes/footer.tpl"}
{/block}
