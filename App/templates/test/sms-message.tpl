{extends file="layouts/core.tpl"}

{block name="head"}
	{include file='includes/head/main-head.tpl'}

{/block}

{block name="body"}
	{include file='includes/navigation/main-menu.tpl'}
	<div class="con-cnt-xxlrg push-t-lrg push-b-lrg">
		<form action="" method="post">
			<p class="text-sml">Message Body:</p>
			<textarea class="inp textarea" name="body" required="required"></textarea>
			<div class="clear"></div>
			<button class="btn btn-inline bg-deep-purple push-t-sml">Send</button>
		</form>
	</div>
{/block}

{block name="footer"}
	{include file='includes/footer.tpl'}
{/block}
