{extends file="layouts/braintree-payment-core.tpl"}

{block name="braintree-payment-head"}{/block}
{block name="braintree-payment-body"}
	<div class="con-cnt-med-plus-plus push-t-med">
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
{/block}
{block name="footer"}{/block}
