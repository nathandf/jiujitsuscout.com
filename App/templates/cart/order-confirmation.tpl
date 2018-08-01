{extends file="layouts/core.tpl"}

{block name="head"}{/block}

{block name="body"}
	{include file="includes/navigation/main-menu.tpl"}
	<div class="con-cnt-xlrg push-t-lrg">
		{foreach from=$orderProducts item=orderProduct}
		<div class="push-t">
			<h3>{$orderProduct->product->name}</h3>
			<p>Price: {$orderProduct->product->currency_symbol}{$orderProduct->product->price}</p>
			<p>Quantity: {$orderProduct->quantity}</p>
			<div class="hr-sml"></div>
		</div>
		{/foreach}
		{if $orderProducts|@count > 0}
			<h2>Total: {$currency_symbol}{$transaction_total}</h2>
			<form action="{$HOME}cart/pay" method="post">
				<input type="hidden" name="token" value="{$csrf_token}">
				<button type="submit" class="btn btn-inline bg-dark-mint tc-white push-t-med" href="{$HOME}cart/pay">Checkout</button>
			</form>
		{else}
			<p>You cart is empty!</p>
		{/if}
	</div>
{/block}

{block name="footer"}{/block}
