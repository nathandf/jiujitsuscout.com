{extends file="layouts/core.tpl"}

{block name="head"}{/block}

{block name="body"}
	{include file="includes/navigation/main-menu.tpl"}
	<div class="con-cnt-xlrg push-t-lrg">
		<div class="inner-pad-med">
			{foreach from=$orderProducts item=orderProduct}
			<div class="push-t">
				<form action="" method="post">
					<input type="hidden" name="token" value="{$csrf_token}">
					<input type="hidden" name="delete" value="{$csrf_token}">
					<input type="hidden" name="order_id" value="{$orderProduct->order_id}">
					<input type="hidden" name="order_product_id" value="{$orderProduct->id}">
					<button type="submit" class="tc-error-red text-lrg-heavy cursor-pt floatright" style="background: none;">x</button>
				</form>
				<h3>{$orderProduct->product->name}</h3>
				<p><span class="text-sml">Price: </span>{$orderProduct->product->currency_symbol}{$orderProduct->product->price}</p>
				<p><span class="text-sml">Qty: </span>{$orderProduct->quantity}</p>
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
	</div>
{/block}

{block name="footer"}{/block}
