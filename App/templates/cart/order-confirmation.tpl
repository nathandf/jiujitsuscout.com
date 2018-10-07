{extends file="layouts/core.tpl"}

{block name="head"}
	<script src="https://js.braintreegateway.com/web/dropin/1.11.0/js/dropin.min.js"></script>
{/block}

{block name="body"}
	{include file="includes/navigation/main-menu.tpl"}
	<div class="con-cnt-xxlrg push-t-lrg">
		{if $orderProducts|@count > 0}
			<div style="margin-top: 12px;" class="con-half-min-320 cnt-640 floatleft inner-pad-med">
				<div class="bg-white inner-pad-med" style="border-radius: 4px; border: 1px solid #B5B5B5;" >
				{foreach from=$orderProducts item=orderProduct}
					<div class="push-b-med">
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
						{if !is_null( $orderProduct->description )}<p><span class="text-sml">Description: </span>{$orderProduct->description}</p>{/if}
						<div class="hr-sml"></div>
					</div>
				{/foreach}
				<p><span class="text-sml-heavy">Total: </span>{$currency_symbol}{$transaction_total}</p>
				</div>
			</div>

			<div class="con-half-min-320 cnt-640 floatleft">
				<div id="output"></div>
				<div id="braintree-dropin-container"></div>
				<button class="btn btn-inline bg-approved-green col-100 tc-white push-t" id="submit-button">Complete Purchase</button>
				<p class="text-sml">By clicking "Complete Purchase" you agree to JiuJitsuScout's <a target="_blank" href="{$HOME}terms-and-conditions">Terms and Conditions</a> and <a target="_blank" href="{$HOME}privacy-policy">Privacy Policy</a>, and consent to enroll your product(s) in our automatic renewal service, which can be cancelled at any time. Automatic renewals are billed to your default payment method until cancelled.</p>
			</div>
			{literal}
			<script>
				var button = document.querySelector('#submit-button');
				braintree.dropin.create({
					authorization: '{/literal}{$client_token}{literal}',
					container: '#braintree-dropin-container'
				}, function (createErr, instance) {
					button.addEventListener('click', function () {
						instance.requestPaymentMethod(function (err, payload) {
							var payment_processing_url = "{/literal}{$HOME}{literal}cart/process-payment?payment_method_nonce=" + payload.nonce;
							window.location.replace( payment_processing_url );
						} );
					} );
				});
			</script>
			{/literal}
		{else}
			<p>You cart is empty!</p>
		{/if}
	</div>
{/block}

{block name="footer"}{/block}
