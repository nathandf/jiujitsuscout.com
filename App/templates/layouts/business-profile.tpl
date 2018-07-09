{extends file="layouts/core.tpl"}

{block name="head"}
	{include file='includes/head/main-head.tpl'}
	<link rel="stylesheet" type="text/css" href="{$HOME}css/ma-profile-main.css"/>
	{block name="business-profile-head"}{/block}
{/block}

{block name="body"}
	{include file='includes/navigation/martial-arts-gym-top-nav.tpl'}
	<div class="con-cnt-xxlrg push-t-lrg mat-box-shadow push-b-lrg bg-white" style="border: 1px solid #CCC;" itemscope itemtype="http://schema.org/LocalBusiness">
		{include file='includes/snippets/business-name.tpl'}
		{include file='includes/navigation/martial-arts-gym-nav.tpl'}
		{block name="business-profile-body"}{/block}
	</div>
{/block}

{block name="footer"}
	{include file='includes/footer.tpl'}
{/block}
