{extends file="layouts/braintree-payment-core.tpl"}

{block name="braintree-payment-head"}{/block}
{block name="braintree-payment-body"}
	<div id="dropin-container"></div>
	<button id="submit-button">Request payment method</button>
	{literal}
	<script>
		var button = document.querySelector('#submit-button');

		braintree.dropin.create({
			authorization: 'CLIENT_TOKEN_FROM_SERVER',
			container: '#dropin-container'
		}, function (createErr, instance) {
			button.addEventListener('click', function () {
				instance.requestPaymentMethod(function (err, payload) {
					// Submit payload.nonce to your server
				});
			});
		});
	</script>
	{/literal}
{/block}
{block name="footer"}{/block}
