{extends file="layouts/braintree-payment-core.tpl"}

{block name="braintree-payment-head"}{/block}
{block name="braintree-payment-body"}
	<div class="con-cnt-med-plus-plus push-t-med">
		<div id="output"></div>
		<div id="braintree-dropin-container"></div>
		<button class="btn btn-inline bg-dark-mint tc-white push-t" id="submit-button">Request payment method</button>
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
					$.post( "{/literal}{$HOME}cart/{literal}process-payment", {
						payment_method_nonce:payload.nonce,
						total:{/literal}{$total}{literal}
					}, function () {
						//
					} ).done( function() {
						if () {
							window.location.replace("{/literal}{$HOME}{literal}cart/payment-success");
						} else {
							window.location.replace("{/literal}{$HOME}{literal}cart/payment-failure");
						}

					} ).fail( function () {
						alert( "There was an error" );
					} );
				} );
			} );
		});
	</script>
	{/literal}
{/block}
{block name="footer"}{/block}
