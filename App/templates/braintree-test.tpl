{extends file="layouts/braintree-payment-core.tpl"}

{block name="braintree-payment-head"}{/block}
{block name="braintree-payment-body"}
	<div class="con-cnt-med">
	<div id="dropin-container"></div>
	<button id="submit-button">Request payment method</button>
	</div>
	{literal}
	<script>
		var button = document.querySelector('#submit-button');

		braintree.dropin.create({
			authorization: '{/literal}{$client_token}{literal}',
			container: '#dropin-container'
		}, function (createErr, instance) {
			button.addEventListener('click', function () {
				instance.requestPaymentMethod(function (err, payload) {
					alert(payload.nonce);
				});
			});
		});
	</script>
	{/literal}
{/block}
{block name="footer"}{/block}
