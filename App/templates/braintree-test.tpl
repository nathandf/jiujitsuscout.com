{extends file="layouts/core.tpl"}

{block name="head"}{/block}

{block name="body"}
	<div class="con-cnt-xlrg push-t-lrg">
		{foreach from=$products item=product}
		<div class="push-t">
			<h3>{$product->name}</h3>
			<p>Price: {$product->price}</p>
			<p>Quantity: 1</p>
			<form action="{$HOME}account-manager/upgrade" method="post">
				<!-- <input type="hidden" name="billing_frequency" value="monthly">
				<input type="hidden" name="token" value="{$csrf_token}"> -->
				<input type="hidden" name="product_ids[]" value="{$product->id}">
				<button type="submit" class="btn btn-inline bg-dark-mint tc-white push-t-med" href="{$HOME}cart/pay">Add</button>
			</form>
			<div class="hr-sml"></div>
		</div>
		{/foreach}
	</div>
{/block}

{block name="footer"}{/block}
