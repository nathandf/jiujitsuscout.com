{extends file="layouts/core.tpl"}

{block name="head"}
	<script src="https://js.braintreegateway.com/web/dropin/1.11.0/js/dropin.min.js"></script>
	{block name="braintree-payment-head"}{/block}
{/block}

{block name=body}
	{block name="braintree-payment-body"}{/block}
{/block}

{block name=footer}
	{block name="braintree-payment-footer"}{/block}
{/block}
